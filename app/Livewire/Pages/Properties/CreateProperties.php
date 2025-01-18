<?php

namespace App\Livewire\Pages\Properties;

use App\Livewire\Forms\Properties\CreatePropertyForm;
use App\Models\TypeProperty;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProperties extends Component
{
    public CreatePropertyForm $form;

    use WithFileUploads;
    public $typeProperties;

    public function mount()
    {
        $this->typeProperties = TypeProperty::all();
    }

    public function save()
    {
        try {
            $this->form->store();
            session()->flash('success', 'Propriedade salva com sucesso!');
            $this->dispatch('propertyCreated');
            return $this->redirect('/properties');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.pages.properties.create-properties')->layout('layouts.app');
    }
}
