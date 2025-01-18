<?php

namespace App\Livewire\Pages\Properties;

use App\Models\Company;
use App\Models\Property;
use Carbon\Carbon;
use Livewire\Component;

class HomeProperties extends Component
{
    public $search = '';
    public $properties;

    public function updatedSearch()
    {
        $this->properties = Property::with(['city', 'state', 'neighborhood'])
            ->when($this->search, function ($query) {
                $query->whereHas('city', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('state', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('neighborhood', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->get();

        $this->dispatch('propertiesFiltered', $this->properties);
    }


    public function render()
    {
        $this->properties = Property::with(['neighborhood', 'city', 'state', 'images'])->withTrashed()->get();

        return view('livewire.pages.properties.home-properties',[
            'properties' => $this->properties
        ])->layout('layouts.app');
    }
}
