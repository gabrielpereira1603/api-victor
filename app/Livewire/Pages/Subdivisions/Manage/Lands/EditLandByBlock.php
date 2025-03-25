<?php

namespace App\Livewire\Pages\Subdivisions\Manage\Lands;

use App\Livewire\Forms\Lands\EditLandsForm;
use App\Models\Blocks;
use App\Models\Lands;
use Livewire\Attributes\On;
use Livewire\Component;

class EditLandByBlock extends Component
{
    public EditLandsForm $form;

    public $first_coordinate;
    public $land_id;

    public $land;

    public $subdivision;

    public $block;
    public $blocks_coordinate;
    public $lands_coordinate;
    public $subdivision_details;
    protected $listeners = ['updateCoordinates' => 'setCoordinates'];
    public function setCoordinates($coordinates)
    {
        if (isset($coordinates['coordinates'])) {
            $coordinates = $coordinates['coordinates'];
        }

        $this->form->coordinates = $coordinates;

    }

    public function mount($land_id){

        $this->land = Lands::with('blocks.subdivision')->find($land_id);
        $this->startForm($this->land);
        $this->block = $this->land->blocks;
        $this->subdivision = $this->block->subdivision;
        $this->first_coordinate = $this->land->first_coordinate;

        $this->form->blocks = Blocks::where('subdivision_id', $this->subdivision->id)->get();
        $this->form->block_id = $this->block->id;

        $subdivision_id = $this->subdivision->id;

        $this->blocks_coordinate = Blocks::where('id', $this->block->id)->get()->map(function ($block) {
            return [
                'name' => $block->name,
                'status' => $block->status,
                'area' => $block->area,
                'coordinates' => $block->coordinates,
            ];
        })->toJson();

        $this->lands_coordinate = Lands::whereHas('blocks', function ($query) use ($subdivision_id) {
            $query->where('subdivision_id', $subdivision_id);
        })
            ->where('id', '!=', $this->land_id)
            ->get()
            ->map(function ($land) {
                return [
                    'name' => $land->name,
                    'code' => $land->code,
                    'status' => $land->status,
                    'area' => $land->area,
                    'coordinates' => $land->coordinates,
                ];
            })
            ->toJson();

        $this->subdivision_details = [
            'name' => $this->subdivision->name,
            'city' => $this->subdivision->city->name,
            'state' => $this->subdivision->state->name,
            'neighborhood' => $this->subdivision->neighborhood->name,
            'status' => $this->subdivision->status,
            'area' => $this->subdivision->area,
            'color' => $this->subdivision->color,
        ];
    }


    public function startForm(Lands $land)
    {
        // Inicializa as propriedades do formulário
        $this->form->name = $land->name;
        $this->form->code = $land->code;


        // Atribui valores de status, área e cor
        $this->form->status = $land->status;
        $this->form->area = $land->area;
        $this->form->color = $land->color;

        $this->form->blocks = $this->block;

        $this->form->subdivision = $this->subdivision;
    }

    public function save()
    {
        try {
            $success = $this->form->store($this->first_coordinate, $this->land->id);

            if ($success) {
                session()->flash('success', 'Terreno cadastrado com sucesso!');
                return redirect()->to('/subdivision/view_one/' . $this->subdivision->id);
            } else {
                return redirect()->to('/create-block');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed', $e->getMessage());
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.pages.subdivisions.manage.lands.edit-land-by-block')->layout('layouts.app');
    }
}
