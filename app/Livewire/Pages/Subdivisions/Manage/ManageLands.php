<?php

namespace App\Livewire\Pages\Subdivisions\Manage;

use App\Models\Subdivision;
use Livewire\Component;

class ManageLands extends Component
{
    public $subdivision;
    public $blocks;

    public function mount($subdivision_id)
    {
        $this->subdivision = Subdivision::findOrFail($subdivision_id);
        $this->blocks = $this->subdivision->blocks->map(function ($block) {
            // Contar o número de terrenos ativos e desativados
            $activeLands = $block->lands->where('status', 'active')->count();
            $disabledLands = $block->lands->where('status', 'disabled')->count();

            return [
                'id' => $block->id,
                'name' => $block->name,
                'coordinates' => $block->coordinates ? json_decode($block->coordinates, true) : [],
                'status' => $block->status,
                'color' => $block->color,
                'area' => $block->area,
                'code' => $block->code,
                'activeLands' => $activeLands,
                'disabledLands' => $disabledLands,
            ];
        });
    }

    public function render()
    {
        return view('livewire.pages.subdivisions.manage.manage-lands')->layout('layouts.app');
    }
}
