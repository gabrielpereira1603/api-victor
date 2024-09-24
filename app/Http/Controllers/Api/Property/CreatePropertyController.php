<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Neighborhood;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreatePropertyController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'value' => 'required|',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'parking_spaces' => 'required|integer|min:0',
            'living_rooms' => 'nullable|integer|min:0',
            'kitchens' => 'nullable|integer|min:0',
            'pools' => 'nullable|integer|min:0',
            'built_area' => 'nullable',
            'land_area' => 'nullable',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $validator->errors()
            ], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo_url')) {
            $photoPath = $request->file('photo_url')->store('properties_images', 'public');
        }

        $state = State::firstOrCreate(['name' => $request->state, 'slug' => Str::slug($request->state)]);
        $city = City::firstOrCreate([
            'name' => $request->city,
            'slug' => Str::slug($request->city),
            'state_id' => $state->id
        ]);

        $neighborhoodId = null;
        if ($request->neighborhood) {
            $neighborhood = Neighborhood::firstOrCreate([
                'name' => $request->neighborhood,
                'slug' => Str::slug($request->neighborhood),
                'city_id' => $city->id
            ]);
            $neighborhoodId = $neighborhood->id;
        }

        $property = Property::create([
            'photo_url' => $photoPath,
            'maps' => $request->maps,
            'value' => $request->value,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'suites' => $request->suites ?? 0,
            'living_rooms' => $request->living_rooms,
            'kitchens' => $request->kitchens,
            'parking_spaces' => $request->parking_spaces,
            'pools' => $request->pools ?? 0,
            'built_area' => $request->built_area,
            'land_area' => $request->land_area,
            'neighborhood_id' => $neighborhoodId,
            'city_id' => $city->id,
            'state_id' => $state->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Propriedade cadastrada com sucesso!',
            'property' => $property
        ], 201);
    }
}
