<?php

namespace App\Livewire\Pages\Subdivisions;

use App\Livewire\Forms\Subdivisions\CreateSubdivisionForm;
use Livewire\Component;

class CreateSubdivisions extends Component
{
    public CreateSubdivisionForm $form;

    public function addCoordinate()
    {
        $this->form->coordinates[] = '';
    }

    public function removeCoordinate($index)
    {
        unset($this->form->coordinates[$index]);
        $this->form->coordinates = array_values($this->form->coordinates);
    }

    public function save()
    {
        try {
            $this->form->store();
            session()->flash('success', 'Loteamento salva com sucesso!');
            $this->dispatch('subdivisionCreated');
            return $this->redirect('/subdivision');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }

    }

    public function render()
    {
        return view('livewire.pages.subdivisions.create-subdivisions')->layout('layouts.app');
    }
}
