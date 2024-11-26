<?php

namespace App\Http\Controllers\Web\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Property;
use App\Models\State;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Support\Str;

class UpdatePropertyController extends Controller
{
    public function index(Property $property)
    {
        $property->load(['neighborhood', 'city', 'state']);
        return view('properties.edit', compact('property'));
    }

    // Atualiza a propriedade
    public function update(Request $request, Property $property)
    {
        $validator = $request->validate([
            'value' => 'required|numeric',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'suites' => 'nullable|integer|min:0',
            'living_rooms' => 'nullable|integer|min:0',
            'kitchens' => 'nullable|integer|min:0',
            'parking_spaces' => 'required|integer|min:0',
            'pools' => 'nullable|integer|min:0',
            'built_area' => 'required|string',
            'land_area' => 'required|string',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Verifica ou cria o estado
        $state = State::firstOrCreate(
            ['slug' => Str::slug($request->state)],
            ['name' => $request->state]
        );

        // Verifica se a cidade já existe para o estado específico
        $city = City::where('slug', Str::slug($request->city))
            ->where('state_id', $state->id)
            ->first();

        if (!$city) {
            $city = City::create([
                'slug' => Str::slug($request->city),
                'state_id' => $state->id,
                'name' => $request->city
            ]);
        }

        // Verifica ou cria o bairro, se fornecido
        $neighborhoodId = null;
        if ($request->neighborhood) {
            $neighborhood = Neighborhood::where('slug', Str::slug($request->neighborhood))
                ->where('city_id', $city->id)
                ->first();

            if (!$neighborhood) {
                $neighborhood = Neighborhood::create([
                    'name' => $request->neighborhood,
                    'slug' => Str::slug($request->neighborhood),
                    'city_id' => $city->id
                ]);
            }
            $neighborhoodId = $neighborhood->id;
        }

        // Atualiza a foto se um novo arquivo foi enviado
        if ($request->hasFile('photo_url')) {
            // Remove a foto antiga se existir
            if ($property->photo_url) {
                $oldPhotoPath = str_replace(asset('storage/'), '', $property->photo_url);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }
            }

            // Salva a nova foto
            $photoPath = $request->file('photo_url')->store('properties_images', 'public');
            $property->photo_url = asset('storage/' . $photoPath);
        }

        // Atualiza os dados da propriedade
        $property->update([
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
            'state_id' => $state->id,
        ]);

        return redirect()->route('properties')->with('success', 'Propriedade atualizada com sucesso!');
    }

    // Deleta a foto de capa da propriedade
    public function deletePhoto(Property $property)
    {
        if ($property->photo_url) {
            // Remove a foto antiga se existir
            $photoPath = str_replace(asset('storage/'), '', $property->photo_url);
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            // Remove a URL da foto do banco de dados
            $property->update(['photo_url' => null]);
        }

        return redirect()->route('properties.update', $property)->with('success', 'Foto da capa removida com sucesso!');
    }
}
