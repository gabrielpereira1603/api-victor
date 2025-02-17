<?php

namespace App\Livewire\Pages\Subdivisions;

use App\Models\Property;
use App\Models\Subdivision;
use Livewire\Component;

class HomeSubdivisions extends Component
{
    public $search = '';
    public $subdivisions;

    public function render()
    {
        $this->subdivisions = Subdivision::with(['neighborhood', 'city', 'state'])->withTrashed()->get();

        return view('livewire.pages.subdivisions.home-subdivisions', [
            'subdivisions' => $this->subdivisions,
        ])->layout('layouts.app');
    }
}
