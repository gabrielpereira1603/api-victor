<?php

namespace App\Http\Controllers\Web\Property;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function indexCreate()
    {
        $properties = Property::with(['neighborhood', 'city', 'state'])->withTrashed()->get();
        return view('properties.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'value' => 'required|numeric',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'parking_spaces' => 'required|integer|min:0',
            'living_rooms' => 'nullable|integer|min:0',
            'kitchens' => 'nullable|integer|min:0',
            'pools' => 'nullable|integer|min:0',
            'built_area' => 'nullable|string',
            'land_area' => 'nullable|string',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('properties')->withErrors($validator)->withInput();
        }

        $photoPath = null;

        if ($request->hasFile('photo_url')) {
            $photoPath = $request->file('photo_url')->store('properties_images', 'public');
            Log::info('Caminho da imagem armazenado: ' . $photoPath);
        } else {
            Log::warning('Nenhuma imagem foi enviada.');
        }

        $fullPath = $photoPath ? asset('storage/' . $photoPath) : null;

        // Cria ou obtém o estado
        $state = State::firstOrCreate(
            ['slug' => Str::slug($request->state)],
            ['name' => $request->state]
        );

        // Verifica se a cidade já existe para o estado específico
        $city = City::where('slug', Str::slug($request->city))
            ->where('state_id', $state->id)
            ->first();

        // Se a cidade não existir, cria um novo registro
        if (!$city) {
            $city = City::create([
                'slug' => Str::slug($request->city),
                'state_id' => $state->id,
                'name' => $request->city
            ]);
        }

        // Cria ou obtém o bairro, se fornecido
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

        // Cria a propriedade
        $property = Property::create([
            'photo_url' => $fullPath,
            'value' => $request->value,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
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

        return redirect()->route('properties')->with('success', 'Propriedade ' . $property->id . ' cadastrada com sucesso!');
    }

    public function disable(Property $property)
    {
        $property->delete();
        return redirect()->route('properties')->with('success', 'Propriedade desativada com sucesso!');
    }

    public function restore($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->restore();
        return redirect()->route('properties')->with('success', 'Propriedade reativada com sucesso!');
    }

    public function forceDelete($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->forceDelete();
        return redirect()->route('properties')->with('success', 'Propriedade excluída definitivamente com sucesso!');
    }

    public function storePhotos(Request $request, Property $property)
    {
        $request->validate([
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validação para cada imagem
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('properties_images', 'public');
                $property->images()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('properties')->with('status', 'Fotos adicionadas com sucesso!');
    }

}
