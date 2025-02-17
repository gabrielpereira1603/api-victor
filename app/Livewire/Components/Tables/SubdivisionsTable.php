<?php

namespace App\Livewire\Components\Tables;

use App\Models\Property;
use App\Models\Subdivision;
use Livewire\Component;
use Livewire\WithPagination;

class SubdivisionsTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.components.tables.subdivisions-table', [
            'subdivisions' => Subdivision::with(['neighborhood', 'city', 'state'])
                ->withTrashed()
                ->paginate(10),
        ]);
    }
}
