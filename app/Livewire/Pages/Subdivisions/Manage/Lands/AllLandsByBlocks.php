<?php

namespace App\Livewire\Pages\Subdivisions\Manage\Lands;

use Livewire\Component;
use App\Models\Blocks;
use App\Models\Lands;

class AllLandsByBlocks extends Component
{
    public $block;
    public $lands;
    public $subdivision_id;

    public function mount($block_id)
    {
        $this->block = Blocks::findOrFail($block_id);
        $this->subdivision_id = $this->block->subdivision_id;

        $this->lands = $this->block->lands->map(function ($land) {
            return [
                'id' => $land->id,
                'name' => $land->name,
                'code' => $land->code,
                'coordinates' => $land->coordinates ? json_decode($land->coordinates, true) : [],
                'status' => $land->status,
                'color' => $land->color,
                'area' => $land->area,
                'background_size' => $land->background_size,
                'front_size' => $land->front_size,
            ];
        });
    }

    public function render()
    {
        return view('livewire.pages.subdivisions.manage.lands.all-lands-by-blocks')->layout('layouts.app');
    }
}
