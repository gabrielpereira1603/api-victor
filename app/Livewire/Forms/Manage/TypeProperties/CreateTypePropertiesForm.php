<?php

namespace App\Livewire\Forms\Manage\TypeProperties;

use App\Models\TypeProperty;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateTypePropertiesForm extends Form
{
    #[Validate('required|string|unique:type_properties,name')]
    public $name;

    public $typeProperty;

    public function store($name)
    {
        DB::beginTransaction();
        try{
            $this->validate();

            TypeProperty::create([
                'name' => $this->name
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            session()->flash('error', 'Erro ao salvar o tipo da propiedade: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'name' => 'required|string|unique:type_properties,name,' . $id,
            ]);

            $typeProperty = TypeProperty::findOrFail($id);
            $typeProperty->update(['name' => $this->name]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Erro ao atualizar o tipo de propriedade: ' . $e->getMessage());
        }
    }
}
