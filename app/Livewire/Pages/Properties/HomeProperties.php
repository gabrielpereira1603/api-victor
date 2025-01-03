<?php

namespace App\Livewire\Pages\Properties;

use App\Models\Property;
use Livewire\Component;

class HomeProperties extends Component
{

    public function render()
    {
        $properties = Property::with(['neighborhood', 'city', 'state', 'images'])->withTrashed()->get();

        return view('livewire.pages.properties.home-properties',[
            'properties' => $properties
        ])->layout('layouts.app');
    }
}
