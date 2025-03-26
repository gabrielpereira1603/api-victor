<?php

namespace App\Livewire\Pages\Subdivisions\Manage;

use App\Models\Subdivision;
use Livewire\Component;

class ManageBloks extends Component
{
    public $subdivision;
    public $blocks;

    public function mount($subdivision_id)
    {
        $this->subdivision = Subdivision::findOrFail($subdivision_id);
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
    }

    public function render()
    {
        return view('livewire.pages.subdivisions.manage.manage-bloks')->layout('layouts.app');
    }
}
