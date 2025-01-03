<?php

namespace App\Livewire\Components\Tables;

use App\Models\Property;
use Livewire\Component;

class PropertiesTable extends Component
{
    public $properties;
    public function render()
    {

        return view('livewire.components.tables.properties-table');
    }
}
