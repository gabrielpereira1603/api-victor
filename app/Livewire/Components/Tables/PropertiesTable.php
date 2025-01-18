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



    public function render()
    {
        return view('livewire.components.tables.properties-table', [
            'properties' => Property::with(['neighborhood', 'city', 'state', 'images'])
                ->withTrashed()
                ->paginate(10),
        ]);
    }
}
