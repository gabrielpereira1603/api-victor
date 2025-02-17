<?php

namespace App\Livewire\Components\Modals\Lands;

use App\Livewire\Forms\Lands\CreateLandsForm;
use App\Models\Blocks;
use App\Models\Lands;
use App\Models\Subdivision;
use App\Models\TypeProperty;
use Livewire\Component;

class CreateLandsModal extends Component
{
    public CreateLandsForm $form;

    public $showInput = false;
    public $editingId = null;

    public function toggleInput()
    {
        $this->showInput = !$this->showInput;
        $this->editingId = null;
    }

    public function addCoordinate()
    {
        $this->form->coordinates[] = '';
    }

    public function removeCoordinate($index)
    {
        unset($this->form->coordinates[$index]);
        $this->form->coordinates = array_values($this->form->coordinates); // Reindexa o array
    }

    public function deleteLand($id)
    {
    }

    public function editLand($id)
    {

    }

    public function mount(Subdivision $subdivision)
    {
        $this->form->subdivision = $subdivision;
        $this->form->lands = Lands::all();
        $this->form->blocks = Blocks::all();
    }

    public function save()
    {
        try {
            $this->form->store();
            session()->flash('success', 'Terrenos cadastrado com sucesso!');
            return $this->redirect('/subdivision/view_one/' . $this->form->subdivision->id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }
    public function render()
    {
        return view('livewire.components.modals.lands.create-lands-modal');
    }
}
