<?php

namespace App\Livewire\Components\Modals\Subdivisions\Manage\Lands;

use App\Models\Lands;
use App\Models\Blocks;
use Livewire\Attributes\On;
use Livewire\Component;

class EditMapCoordinateModal extends Component
{
    public $land_id;
    public $land;
    public $block;
    public $otherLands = [];

    #[On('editMapCoordinateLandModal')]
    public function editMapCoordinateLandModal($id): void
    {
        $this->land_id = $id;

        // Busca o terreno e seu quarteirão
        $this->land = Lands::with('blocks')->find($id);

        if (!$this->land) {
            return;
        }

        // Busca o quarteirão do terreno
        $this->block = $this->land->blocks;

        // Busca todas as outras lands do mesmo quarteirão, excluindo a que está sendo editada
        if ($this->block) {
            $this->otherLands = Lands::where('block_id', $this->block->id)
                ->where('id', '!=', $this->land_id)
                ->get();
        }

        $data = [
            'land' => [
                'id' => $this->land->id,
                'name' => $this->land->name,
                'coordinates' => json_decode($this->land->coordinates),
                'first_coordinate' => $this->land->first_coordinate, // Certifique-se de que este campo está preenchido
                'color' => $this->land->color ?? '#FF0000',
            ],
            'block' => [
                'id' => $this->block->id ?? null,
                'name' => $this->block->name ?? '',
                'coordinates' => $this->block ? json_decode($this->block->coordinates) : [],
                'color' => $this->block->color ?? '#00FF00',
            ],
            'otherLands' => $this->otherLands->map(function ($land) {
                return [
                    'id' => $land->id,
                    'name' => $land->name,
                    'coordinates' => json_decode($land->coordinates),
                    'color' => $land->color ?? '#0000FF',
                ];
            }),
            'first_coordinate' => $this->land->first_coordinate, // Adicionando a coordenada inicial aqui
        ];

        // Disparar evento para o frontend com os dados formatados
        $this->dispatch('loadMapData', $data);

        // Disparar evento para o frontend com os dados formatados
        $this->dispatch('open-modal', 'edit-map-coordinate-land-modal');
    }
    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.components.modals.subdivisions.manage.lands.edit-map-coordinate-modal', [
        ]);
    }
}
