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
        Log::info('Iniciando método store.', ['request' => $request->all(), 'files' => $request->file('photos')]);

        if (!$request->hasFile('photos')) {
            Log::error('Nenhuma foto enviada.');
            return back()->withErrors(['photos' => 'Nenhuma foto foi enviada.']);
        }

        $validator = Validator::make($request->all(), [
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::warning('Validação falhou.', ['errors' => $validator->errors()]);
            return redirect()->route('properties')->withErrors($validator)->withInput();
        }

        $property = Property::find($propertyId);
        if (!$property) {
            Log::error('Propriedade não encontrada.', ['property_id' => $propertyId]);
            return redirect()->route('properties')->withErrors(['property' => 'Propriedade não encontrada.']);
        }

        if ($request->hasFile('photos')) {
            Log::info('Fotos recebidas.', ['files' => $request->file('photos')]);

            foreach ($request->file('photos') as $photo) {
                // Armazenando o arquivo
                try {
                    $photoPath = $photo->store('properties_images', 'public');
                    Log::info('Imagem armazenada com sucesso.', ['path' => $photoPath]);

                    // Salvando no banco de dados
                    $image = PropertyImage::create([
                        'property_id' => $property->id,
                        'image_url' => asset('storage/' . $photoPath),
                    ]);
                    Log::info('Imagem salva no banco de dados.', ['image' => $image]);
                } catch (\Exception $e) {
                    Log::error('Erro ao salvar imagem.', ['error' => $e->getMessage()]);
                }
            }
        } else {
            Log::warning('Nenhuma foto enviada.');
        }

        return redirect()->route('properties')->with('success', 'Imagens da propriedade ' . $property->id . ' cadastradas com sucesso!');
    }

    public function destroy($photoId)
    {
        Log::info('Iniciando método destroy para excluir foto.', ['photo_id' => $photoId]);

        $photo = PropertyImage::find($photoId);

        if (!$photo) {
            Log::error('Foto não encontrada.', ['photo_id' => $photoId]);
            return redirect()->route('properties')->withErrors(['photo' => 'Foto não encontrada.']);
        }

        $photoPath = str_replace(asset('storage/'), '', $photo->image_url);
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
            Log::info('Arquivo de foto deletado.', ['path' => $photoPath]);
        } else {
            Log::warning('Arquivo de foto não encontrado no sistema.', ['path' => $photoPath]);
        }

        $photo->delete();
        Log::info('Foto removida do banco de dados.', ['photo_id' => $photoId]);

        return redirect()->route('properties')->with('success', 'Foto da propriedade excluída com sucesso!');
    }

    public function clearAllPhotos($propertyId)
    {
        Log::info('Iniciando método clearAllPhotos para limpar todas as fotos.', ['property_id' => $propertyId]);

        $property = Property::find($propertyId);

        if (!$property) {
            Log::error('Propriedade não encontrada.', ['property_id' => $propertyId]);
            return redirect()->route('properties')->withErrors(['property' => 'Propriedade não encontrada.']);
        }

        $photos = PropertyImage::where('property_id', $propertyId)->get();

        if ($photos->isEmpty()) {
            Log::warning('Nenhuma foto cadastrada para essa propriedade.', ['property_id' => $propertyId]);
            return redirect()->route('properties')->with('warning', 'Nenhuma foto cadastrada para essa propriedade.');
        }

        foreach ($photos as $photo) {
            $photoPath = str_replace(asset('storage/'), '', $photo->image_url);
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
                Log::info('Arquivo de foto deletado.', ['path' => $photoPath]);
            } else {
                Log::warning('Arquivo de foto não encontrado no sistema.', ['path' => $photoPath]);
            }

            $photo->delete();
            Log::info('Foto removida do banco de dados.', ['photo_id' => $photo->id]);
        }

        return redirect()->route('properties')->with('success', 'Todas as fotos foram excluídas com sucesso!');
    }

}
