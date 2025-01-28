<?php

namespace App\Livewire\Components\Tables;

use App\Models\Company;
use App\Models\Property;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PropertiesTable extends Component
{
    use WithPagination;


    #[On('propertiesFiltered')]
    public function handleCompaniesFiltered($properties)
    {

    }

    public function restoreProperty($propertyId)
    {
        $property = Property::withTrashed()->findOrFail($propertyId);

        if ($property->trashed()) {
            $property->restore();
            session()->flash('success', 'Propriedade restaurada com sucesso.');
        } else {
            session()->flash('error', 'Propriedade já está ativa.');
        }
    }

    public function forceDeleteProperty($propertyId)
    {
        $property = Property::withTrashed()->findOrFail($propertyId);

        if ($property->trashed()) {
            $property->forceDelete();
            session()->flash('success', 'Propriedade excluída permanentemente.');
        } else {
            session()->flash('error', 'Propriedade deve ser desativada antes de ser excluída permanentemente.');
        }
    }

    public function disableProperty($propertyId)
    {
        $property = Property::findOrFail($propertyId);

        if (!$property->trashed()) {
            $property->delete();
            session()->flash('success', 'Propriedade desativada com sucesso.');
        } else {
            session()->flash('error', 'Propriedade já está desativada.');
        }
    }

    public function render()
    {
        return view('livewire.components.tables.properties-table', [
            'properties' => Property::with(['neighborhood', 'city', 'state', 'images'])
                ->withTrashed()
                ->paginate(10),
        ]);
    }
}
