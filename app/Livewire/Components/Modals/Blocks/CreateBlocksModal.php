<?php

namespace App\Livewire\Components\Modals\Blocks;

use App\Livewire\Forms\Blocks\CreateBlocksForm;
use App\Models\Blocks;
use App\Models\Subdivision;
use App\Models\TypeProperty;
use Livewire\Component;

class CreateBlocksModal extends Component
{
    public CreateBlocksForm $form;

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

    public function deleteBlock($id)
    {
        $typeProperty = TypeProperty::findOrFail($id);
        $typeProperty->delete();

        $this->form->typeProperty = TypeProperty::all();

        session()->flash('success', 'Tipo de propriedade removido com sucesso!');
    }

    public function editBlock($id)
    {
        $typeProperty = TypeProperty::findOrFail($id);
        $this->form->name = $typeProperty->name;
        $this->editingId = $id;
        $this->showInput = true;
    }


    public function mount(Subdivision $subdivision)
    {
        $this->form->blocks = Blocks::all();
        $this->form->subdivision = $subdivision;
    }

    public function save()
    {
        try {
            $this->form->store();
            session()->flash('success', 'Terreno cadastrado com sucesso!');
            return $this->redirect('/subdivision/view_one' . $this->form->subdivision->id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.components.modals.blocks.create-blocks-modal');
    }
}
