<?php

namespace App\Livewire\Components\Modals;

use App\Models\Property;
use Livewire\Component;

class ViewPropertyModal extends Component
{
    public Property $property;

    public function mount($property)
    {
        $this->property = $property;
    }
    public function render()
    {
        return view('livewire.components.modals.view-property-modal');
    }
}
