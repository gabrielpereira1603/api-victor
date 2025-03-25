<?php

namespace App\Livewire\Components\Modals\Subdivisions\Manage;

use AllowDynamicProperties;
use App\Models\Blocks;
use Livewire\Attributes\On;
use Livewire\Component;

#[AllowDynamicProperties] class EditCoordinateBlockModal extends Component
{
    public $block_id;

    public $coordinates = [];

    #[On('editCoordinateBlock')]
    public function editCoordinateBlockModalOpen($id): void
    {
        $this->block_id = $id;

        // Busca as coordenadas do bloco no banco de dados
        $block = Blocks::find($id);
        if ($block && $block->coordinates) {
            $this->coordinates = json_decode($block->coordinates, true);
        }

        $this->dispatch('open-modal', 'edit-coordinate-block');
        $this->dispatch('loadEditMap', $this->coordinates);
    }

    public function updateCoordinates($updatedCoordinates)
    {
        $block = Blocks::find($this->block_id);
        if ($block) {
            $block->coordinates = json_encode($updatedCoordinates);
            $block->save();
        }

        $this->dispatch('close-modal', 'edit-coordinate-block');
        $this->dispatch('blockCoordinatesUpdated');
    }

    public function render()
    {
        return view('livewire.components.modals.subdivisions.manage.edit-coordinate-block-modal');
    }
}
