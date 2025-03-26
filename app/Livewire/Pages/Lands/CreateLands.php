<?php

namespace App\Livewire\Pages\Lands;

use App\Livewire\Forms\Lands\CreateLandsForm;
use App\Models\Blocks;
use App\Models\Lands;
use App\Models\Subdivision;
use Livewire\Component;

class CreateLands extends Component
{
    public CreateLandsForm $form;

    public $first_coordinate;
    public $blocks_coordinate;
    public $lands_coordinate;
    public $subdivision_details;

    public $blocks;

    public $subdivision_id;

    protected $listeners = ['updateCoordinates' => 'setCoordinates'];

    public function setCoordinates($coordinates)
    {
        if (isset($coordinates['coordinates'])) {
            $coordinates = $coordinates['coordinates'];
        }

        $this->form->coordinates = $coordinates;

    }

    public function save()
    {
        try {
            $success = $this->form->store($this->first_coordinate);

            if ($success) {
                session()->flash('success', 'Terreno cadastrado com sucesso!');
                return redirect()->to('/lands/create/' . $this->form->subdivision->id);
            } else {
                return redirect()->to('/lands/create/' . $this->form->subdivision->id);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }
    public function mount($subdivision_id)
    {
        $this->subdivision_id = $subdivision_id;
        $subdivision = Subdivision::findOrFail($subdivision_id);
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

        $this->lands_coordinate = Lands::whereHas('blocks', function ($query) use ($subdivision_id) {
            $query->where('subdivision_id', $subdivision_id);
        })->get()->map(function ($land) {
            return [
                'name' => $land->name,
                'code' => $land->code,
                'status' => $land->status,
                'area' => $land->area,
                'front_size' => $land->front_size,
                'background_size' => $land->background_size,
                'coordinates' => $land->coordinates,
                'color' => $land->color,

            ];
        })->toJson();

        $this->blocks = Blocks::where('subdivision_id', $subdivision_id)->get();

        $this->subdivision_details = [
            'name' => $subdivision->name,
            'city' => $subdivision->city->name,
            'state' => $subdivision->state->name,
            'neighborhood' => $subdivision->neighborhood->name,
            'status' => $subdivision->status,
            'area' => $subdivision->area,
            'color' => $subdivision->color,
        ];

        if (!empty($this->first_coordinate)) {
            $this->dispatch('firstCoordinateUpdated', $this->first_coordinate);
        }
    }


    public function render()
    {
        return view('livewire.pages.lands.create-lands')->layout('layouts.app');
    }
}
