<?php

namespace App\Livewire\Components\Modals;

use App\Models\Property;
use LivewireUI\Modal\ModalComponent;

class PropertiesPhotosModal extends ModalComponent
{
    public Property $property;
    public $photos;

    public static function modalMaxWidth(): string
    {
        return '2xl'; // Largura máxima do modal
    }

    public function mount($property)
    {
        $this->property = $property;
        $this->photos = $this->property->images; // Ou o que for apropriado
    }
    public function render()
    {
        return view('livewire.components.modals.properties-photos-modal');
    }
}

