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

        // Validação
        $validator = Validator::make($request->all(), [
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::warning('Validação falhou.', ['errors' => $validator->errors()]);
            return redirect()->route('properties')->withErrors($validator)->withInput();
        }

        // Verificando se a propriedade existe
        $property = Property::find($propertyId);
        if (!$property) {
            Log::error('Propriedade não encontrada.', ['property_id' => $propertyId]);
            return redirect()->route('properties')->withErrors(['property' => 'Propriedade não encontrada.']);
        }

        // Verificando envio de arquivos
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

        // Removendo arquivo
        $photoPath = str_replace(asset('storage/'), '', $photo->image_url);
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
            Log::info('Arquivo de foto deletado.', ['path' => $photoPath]);
        } else {
            Log::warning('Arquivo de foto não encontrado no sistema.', ['path' => $photoPath]);
        }

        // Deletando do banco de dados
        $photo->delete();
        Log::info('Foto removida do banco de dados.', ['photo_id' => $photoId]);

        return redirect()->route('properties')->with('success', 'Foto da propriedade excluída com sucesso!');
    }
}
