<?php

namespace App\Livewire\Components\Modals;

use App\Livewire\Forms\Properties\UploadPhotosPropertyForm;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertiesPhotosModal extends Component
{
    use WithFileUploads;

    public UploadPhotosPropertyForm $form;

    public function clearPreviewPhotos($index = null): void
    {
        if(isset($index)){
            if (isset($this->form->photos[$index])) {
                unset($this->form->photos[$index]);
                $this->form->photos = array_values($this->form->photos);
                session()->flash('success', 'Imagem removida com sucesso.');
            }
        } else {
            $this->form->photos = [];
            session()->flash('success', 'Todas as fotos foram removidas com sucesso.');
        }

    }

    public function clearExistingPhoto($id_photo = null): void
    {
        if ($id_photo) {
            $this->form->clearOneExistingPhoto($id_photo);
            session()->flash('success', 'Fotos cadastradas com sucesso.');
        } else {
            $this->form->clearAllExistingPhoto($this->form->property);
            session()->flash('success', 'Foto excluída com sucesso.');
        }

        $this->mount($this->form->property);
    }

    public function save()
    {
        // Log para verificar os arquivos recebidos
        Log::info('Arquivos recebidos:', [
            'quantidade' => count($this->form->photos),
            'tamanho_total' => array_sum(array_map(fn ($photo) => $photo->getSize(), $this->form->photos)) / 1024 . ' KB',
        ]);

        $this->form->store($this->form->property);

        $this->clearPreviewPhotos();
    }


    public function mount(Property $property)
    {
        $this->form->property = $property;
    }

    public function render()
    {
        return view('livewire.components.modals.properties-photos-modal',[
            'existingPhotos' => $this->form->property->images
        ]);
    }
}
