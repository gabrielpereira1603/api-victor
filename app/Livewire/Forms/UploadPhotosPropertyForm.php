<?php

namespace App\Livewire\Forms;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UploadPhotosPropertyForm extends Form
{
    use WithFileUploads;

    #[Validate(['photos.*' => 'image|max:204800'])]
    public $photos = [];

    public $image_url;
    public $file_name;
    public $file_type;
    public $existingPhotos = [];

    public function clearPhotos($index = null): void
    {
        if ($index !== null && isset($this->photos[$index])) {
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos);
        } else {
            $this->photos = [];
        }
    }

    public function clearExistingPhoto($id_photo = null)
    {
        if ($id_photo) {
            DB::beginTransaction();

            try {
                $photo = PropertyImage::find($id_photo);
                if ($photo) {
                    $photoUrl = $photo->image_url;
                    $photoPath = str_replace(asset('storage/'), '', $photoUrl);

                    if (Storage::disk('public')->exists($photoPath)) {
                        Storage::disk('public')->delete($photoPath);
                    }

                    $photo->forceDelete();

                    DB::commit();

                    session()->flash('success', 'Foto excluída com sucesso.');
                } else {
                    session()->flash('error', 'Foto não encontrada.');
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                session()->flash('error', 'Erro ao excluir foto: ' . $e->getMessage());
            }
        }
    }

    public function clearAllExistingPhoto(Property $property)
    {
        DB::beginTransaction();

        try {
            $photos = $property->images;

            if ($photos) {
                session()->flash('error', 'Nenhuma foto encontrada para excluir.');
            }

            foreach ($photos as $photo) {
                $photoUrl = $photo->image_url;
                $photoPath = str_replace(asset('storage/'), '', $photoUrl);

                if (Storage::disk('public')->exists($photoPath)) {
                    Storage::disk('public')->delete($photoPath);
                }

                $photo->forceDelete();
            }

            DB::commit();

            session()->flash('success', 'Todas as fotos foram excluídas com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Erro ao excluir fotos: ' . $e->getMessage());
        }
    }


    public function store(Property $property)
    {
        DB::beginTransaction();

        try {
            if (!empty($this->photos) && is_array($this->photos)) {
                foreach ($this->photos as $photo) {
                    // Salvando com o nome original do arquivo
                    $fileName = $photo->getClientOriginalName();
                    $path = $photo->storeAs('properties_images', $fileName, 'public');

                    // Definindo o URL e outros dados
                    $this->image_url = asset('storage/' . $path);  // Usando o caminho do storage
                    $this->file_name = $fileName;
                    $this->file_type = $photo->getClientMimeType();

                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_url' => $this->image_url,
                        'file_name' => $this->file_name,
                        'file_type' => $this->file_type,
                    ]);
                }

                DB::commit();
                session()->flash('success', 'Fotos cadastradas com sucesso.');
            } else {
                session()->flash('error', 'Nenhuma foto selecionada.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Erro ao salvar fotos: ' . $e->getMessage());
        }
    }

}
