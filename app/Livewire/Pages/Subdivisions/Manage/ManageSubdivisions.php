<?php

namespace App\Livewire\Pages\Subdivisions\Manage;

use App\Models\Subdivision;
use Livewire\Component;

class ManageSubdivisions extends Component
{
    public $subdivision;

    public function mount($subdivision_id)
    {
        $this->subdivision = Subdivision::with('blocks')->findOrFail($subdivision_id);
    }

    public function render()
    {
        return view('livewire.pages.subdivisions.manage.manage-subdivisions')
            ->layout('layouts.app');
    }
}
