<?php

namespace App\Http\Controllers\Web\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyImageController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $validator = Validator::make($request->all(), [
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('properties')->withErrors($validator)->withInput();
        }

        $property = Property::find($propertyId);

        if (!$property) {
            return redirect()->route('properties')->withErrors(['property' => 'Propriedade não encontrada.']);
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPath = $photo->store('properties_images', 'public');
                Log::info('Caminho da imagem armazenado: ' . $photoPath);

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => asset('storage/' . $photoPath),
                ]);
            }
        } else {
            Log::warning('Nenhuma imagem foi enviada.');
        }

        return redirect()->route('properties')->with('success', 'Imagens da propriedade ' . $property->id . ' cadastradas com sucesso!');
    }

    public function destroy($photoId)
    {
        $photo = PropertyImage::find($photoId);

        if (!$photo) {
            return redirect()->route('properties')->withErrors(['photo' => 'Foto não encontrada.']);
        }

        $photoPath = str_replace(asset('storage/'), '', $photo->image_url);
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        $photo->delete();

        return redirect()->route('properties')->with('success', 'Foto da propriedade excluída com sucesso!');
    }
}
