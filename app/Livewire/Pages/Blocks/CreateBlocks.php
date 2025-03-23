<?php

namespace App\Livewire\Pages\Blocks;

use App\Livewire\Forms\Blocks\CreateBlocksForm;
use App\Models\Blocks;
use App\Models\Subdivision;
use App\Models\TypeProperty;
use Livewire\Component;

class CreateBlocks extends Component
{
    public CreateBlocksForm $form;
    public $first_coordinate;
    public $blocks_coordinate;

    public $subdivision_id;


    protected $listeners = ['updateCoordinates' => 'setCoordinates'];

    public function setCoordinates($coordinates)
    {
        if (isset($coordinates['coordinates'])) {
            $coordinates = $coordinates['coordinates'];
        }

        $this->form->coordinates = $coordinates;

    }

    public function mount($subdivision_id)
    {
        $this->subdivision_id = $subdivision_id;
        $subdivision = Subdivision::where('id', $subdivision_id)->firstOrFail();
        $this->form->subdivision = $subdivision;
        $this->first_coordinate = $subdivision->first_coordinate;
        $this->blocks_coordinate = Blocks::where('subdivision_id', $subdivision_id)->get()->map(function ($block) {
            return [
                'name' => $block->name,
                'status' => $block->status,
                'area' => $block->area,
                'coordinates' => $block->coordinates,
            ];
        })->toJson();
        if (!empty($this->first_coordinate)) {
            $this->dispatch('firstCoordinateUpdated', $this->first_coordinate);
        }
    }


    public function save()
    {
        try {
            $success = $this->form->store($this->first_coordinate);

            if ($success) {
                session()->flash('success', 'Quarteirão cadastrado com sucesso!');
                return redirect()->to('/subdivision/view_one/' . $this->form->subdivision->id);
            } else {
                return redirect()->to('/create-block');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.pages.blocks.create-blocks')->layout('layouts.app');
    }
}
