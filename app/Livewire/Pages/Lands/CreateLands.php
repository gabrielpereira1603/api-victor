<?php

namespace App\Livewire\Pages\Lands;

use App\Livewire\Forms\Lands\CreateLandsForm;
use Livewire\Component;

class CreateLands extends Component
{
    public CreateLandsForm $form;
    public $first_coordinate;
    public $subdivison;
    public $blocks;

    protected $listeners = ['updateCoordinates' => 'setCoordinates'];

    public function setCoordinates($coordinates)
    {
        if (isset($coordinates['coordinates'])) {
            $coordinates = $coordinates['coordinates'];
        }

        $this->form->coordinates = $coordinates;

    }
    public function render()
    {
        return view('livewire.pages.lands.create-lands');
    }
}
