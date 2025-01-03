<?php

namespace App\Livewire\Pages\Properties;

use App\Livewire\Forms\CreatePropertyForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProperties extends Component
{
    public CreatePropertyForm $form;
    public $errorMessage = '';
    public $validationErrors = [];

    use WithFileUploads;

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
        return view('livewire.pages.properties.create-properties', [
            'errorMessage' => $this->errorMessage,
            'validationErrors' => $this->validationErrors,
        ])->layout('layouts.app');
    }
}
