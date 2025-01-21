<?php

namespace App\Livewire\Pages\Properties;

use App\Livewire\Forms\Properties\UpdatePropertyForm;
use App\Models\Property;

use App\Models\TypeProperty;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProperties extends Component
{
    use WithFileUploads;

    public UpdatePropertyForm $form;

    public function mount($property_id)
    {
        $this->form->property = Property::with('images', 'state', 'city', 'neighborhood', 'typeProperty')->findOrFail($property_id);

        $this->form->value = $this->form->property->value ?? '';
        $this->form->built_area = $this->form->property->built_area ?? '';
        $this->form->land_area = $this->form->property->land_area ?? '';
        $this->form->bedrooms = $this->form->property->bedrooms ?? 0;
        $this->form->bathrooms = $this->form->property->bathrooms ?? 0;
        $this->form->suites = $this->form->property->suites ?? 0;
        $this->form->living_rooms = $this->form->property->living_rooms ?? 0;
        $this->form->kitchens = $this->form->property->kitchens ?? 0;
        $this->form->parking_spaces = $this->form->property->parking_spaces ?? 0;
        $this->form->pools = $this->form->property->pools ?? 0;
        $this->form->ramps = $this->form->property->ramps ?? 0;
        $this->form->machine_rooms = $this->form->property->machine_rooms ?? 0;
        $this->form->writtens = $this->form->property->writtens ?? 0;
        $this->form->neighborhood = $this->form->property->neighborhood->name ?? '';
        $this->form->city = $this->form->property->city->name ?? '';
        $this->form->state = $this->form->property->state->name ?? '';
        $this->form->description = $this->form->property->description ?? '';
        $this->form->maps = $this->form->property->maps ?? '';
        $this->form->type_property = $this->form->property->typeProperty->id ?? '';
    }

    public function save()
    {
        try {

            $this->form->update();

            $this->dispatch('propertyUpdated', ['message' => 'Propriedade atualizada com sucesso!']);
            session()->flash('success', 'Propriedade salva com sucesso!');

            return $this->redirect('/properties');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.pages.properties.update-properties', [
            'property' => $this->form->property,
            'images' => $this->form->property->images,
            'typeProperties' => TypeProperty::all(),
        ])->layout('layouts.app');
    }
}
