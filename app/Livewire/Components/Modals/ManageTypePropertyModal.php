<?php

namespace App\Livewire\Components\Modals;

use App\Livewire\Forms\Manage\TypeProperties\CreateTypePropertiesForm;
use App\Models\TypeProperty;
use Livewire\Component;

class ManageTypePropertyModal extends Component
{
    public CreateTypePropertiesForm $form;
    public $showInput = false;
    public $editingId = null;


    public function mount()
    {
        $this->form->typeProperty = TypeProperty::all();
    }

    public function toggleInput()
    {
        $this->showInput = !$this->showInput;
        $this->editingId = null;
    }

    public function deleteTypeProperty($id)
    {
        $typeProperty = TypeProperty::findOrFail($id);
        $typeProperty->delete();

        $this->form->typeProperty = TypeProperty::all();

        session()->flash('success', 'Tipo de propriedade removido com sucesso!');
    }

    public function editTypeProperty($id)
    {
        $typeProperty = TypeProperty::findOrFail($id);
        $this->form->name = $typeProperty->name;
        $this->editingId = $id;
        $this->showInput = true;
    }

    public function update()
    {
        $this->form->update($this->editingId);

        $this->form->typeProperty = TypeProperty::all();
        $this->form->name = '';
        $this->editingId = null;
        $this->showInput = false;

        session()->flash('success', 'Tipo de propriedade atualizado com sucesso!');
    }

    public function save()
    {
        try {
            $this->form->store($this->form->name);

            $this->form->typeProperty = TypeProperty::all();

            $this->form->name = '';
            $this->showInput = false;

            session()->flash('success', 'Tipo da propriedade salvo com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.components.modals.manage-type-property-modal');
    }
}
