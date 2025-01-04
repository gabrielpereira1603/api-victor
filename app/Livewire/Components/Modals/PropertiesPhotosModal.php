<?php

namespace App\Livewire\Components\Modals;

use App\Livewire\Forms\UploadPhotosPropertyForm;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;


class PropertiesPhotosModal extends Component
{
    public Property $property;

    public UploadPhotosPropertyForm $form;
    public $errorMessage = '';
    public $validationErrors = [];

    use WithFileUploads;

    public function removePhoto($index)
    {
        // Remover a foto do array de fotos
        unset($this->form['photos'][$index]);

        // Reindexar o array para garantir que os índices estejam corretos
        $this->form['photos'] = array_values($this->form['photos']);
    }

    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        return view('livewire.components.modals.properties-photos-modal',[
            'errorMessage' => $this->errorMessage,
            'validationErrors' => $this->validationErrors,
        ]);
    }
}

