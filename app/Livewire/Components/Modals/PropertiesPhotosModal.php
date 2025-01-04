<?php

namespace App\Livewire\Components\Modals;

use App\Livewire\Forms\UploadPhotosPropertyForm;
use App\Models\Property;
use App\Models\PropertyImage;
use Livewire\Component;
use Livewire\WithFileUploads;


class PropertiesPhotosModal extends Component
{
    public Property $property;

    public UploadPhotosPropertyForm $form;
    public $errorMessage = '';
    public $validationErrors = [];

    public $existingPhotos = [];

    public $confirmDelete = false;


    use WithFileUploads;

    public function clearPhotos($index = null)
    {
        $this->form->clearPhotos($index);
    }

    public function clearExistingPhoto($id_photo = null)
    {
        if ($id_photo === null) {
            if (!$this->confirmDelete) {
                $this->confirmDelete = true;
                $this->mount();
            } else {
                $this->form->clearAllExistingPhoto($this->property);
                $this->confirmDelete = false;
                $this->mount();
            }
        } else {
            if(!$this->confirmDelete){
                $this->confirmDelete = true;
                $this->mount();
            }else {
                $this->form->clearExistingPhoto($id_photo);
                $this->confirmDelete = false;
                $this->mount();
            }
        }
    }


    public function mount()
    {
        $this->existingPhotos = $this->property->images->toArray();
    }

    public function save()
    {
        $this->form->store($this->property);
        $this->existingPhotos = $this->property->images->toArray();
        $this->clearPhotos();
    }

    public function render()
    {
        return view('livewire.components.modals.properties-photos-modal',[
            'errorMessage' => $this->errorMessage,
            'validationErrors' => $this->validationErrors,
        ]);
    }
}

