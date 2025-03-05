<?php

namespace App\Livewire\Pages\Subdivisions;

use App\Livewire\Forms\Subdivisions\CreateSubdivisionForm;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateSubdivisions extends Component
{
    public CreateSubdivisionForm $form;
    public $first_coordinate;
    protected $listeners = ['updateCoordinates' => 'setCoordinates'];

    public function updatedFirstCoordinate($value)
    {
        if (!empty($value)) {
            $this->dispatch('firstCoordinateUpdated', $value);
        }
    }

    public function setCoordinates($coordinates)
    {
        if (isset($coordinates['coordinates'])) {
            $coordinates = $coordinates['coordinates'];
        }

        $this->form->coordinates = $coordinates;

    }

    public function save()
    {
        try {
            $this->form->store($this->first_coordinate);
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
