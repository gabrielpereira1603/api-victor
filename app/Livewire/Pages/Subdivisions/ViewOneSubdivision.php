<?php

namespace App\Livewire\Pages\Subdivisions;

use App\Models\Subdivision;
use Livewire\Component;

class ViewOneSubdivision extends Component
{
    public $subdivision;
    public $coordinates;
    public $blocks;
    public $lands;


    public function mount($subdivision_id)
    {
        $this->subdivision = Subdivision::with('blocks')->findOrFail($subdivision_id);

        $dataCoordinates = json_decode($this->subdivision->coordinates, true);

        if (!is_array($dataCoordinates)) {
            throw new \Exception('Erro: As coordenadas não estão em um formato válido.');
        }

        $this->coordinates = array_map(function ($coord) {
            return array_map('floatval', $coord);
        }, $dataCoordinates);

        $this->blocks = $this->subdivision->blocks->map(function ($block) {
            return [
                'id' => $block->id,
                'name' => $block->name,
                'coordinates' => $block->coordinates ? json_decode($block->coordinates, true) : [],
                'status' => $block->status,
                'color' => $block->color,
                'area' => $block->area,
                'code' => $block->code,
            ];
        });

        $blockIds = $this->subdivision->blocks->pluck('id');
        $this->lands = \App\Models\Lands::whereIn('block_id', $blockIds)->get()->map(function ($land) {
            return [
                'id' => $land->id,
                'name' => $land->name,
                'coordinates' => $land->coordinates ? json_decode($land->coordinates, true) : [],
                'status' => $land->status,
                'color' => $land->color,
                'area' => $land->area,
                'code' => $land->code,
            ];
        });
    }

    public function render()
    {
        return view('livewire.pages.subdivisions.view-one-subdivision')
            ->layout('layouts.app');
    }
}
