<?php
namespace App\Livewire\Forms\Properties;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UploadPhotosPropertyForm extends Form
{
    use WithFileUploads;

    #[Validate(['photos.*' => 'image'])]
    public $photos = [];
    public $image_url;
    public $file_name;
    public $file_type;

    public Property $property;

    public function store(Property $property)
    {
        DB::beginTransaction();

        try {
            if (!empty($this->photos) && is_array($this->photos)) {
                foreach ($this->photos as $photo) {
                    $fileName = $photo->getClientOriginalName();
                    $path = $photo->storeAs('properties_images', $fileName, 'public');

                    $this->image_url = asset('storage/' . $path);
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
            } else {
                session()->flash('error', 'Nenhuma foto selecionada.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Erro ao salvar fotos: ' . $e->getMessage());
        }
    }

    public function clearOneExistingPhoto($id_photo)
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

            if ($photos->isEmpty()) {
                session()->flash('error', 'Nenhuma foto encontrada para excluir.');
                DB::rollback();
                return;
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

}
