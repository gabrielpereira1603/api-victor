<?php

namespace App\Livewire\Forms\Lands;

use App\Models\Lands;
use App\Models\Subdivision;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditLandsForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:255')]
    public $code;

    #[Validate('required|nullable|array')]
    public $coordinates = [];

    #[Validate('required|in:Disponível,Reservado,Indisponível')]
    public $status = 'Disponível';

    #[Validate('nullable|numeric|min:0')]
    public $area;

    #[Validate('required|numeric|min:0')]
    public $front_size;

    #[Validate('required|numeric|min:0')]
    public $background_size;

    public $color = '';

    public $lands;

    #[Validate('required')]
    public $blocks;

    public $subdivision;

    public $block_id;

    public function store($first_coordinate, $land_id)
    {

        $this->area = round($this->background_size * $this->front_size, 2);

        if ($this->status == 'Disponível') {
            $this->color = 'green';
        } elseif ($this->status == 'Reservado') {
            $this->color = 'yellow';
        } elseif ($this->status == 'Indisponível') {
            $this->color = 'red';
        }

        $this->validate();

        DB::beginTransaction();
        try {
            $land = Lands::find($land_id);
            $land->update([
                'block_id' => $this->block_id,
                'name' => $this->name,
                'code' => $this->code,
                'coordinates' => json_encode($this->coordinates),
                'first_coordinate' => $first_coordinate,
                'status' => $this->status,
                'area' => $this->area,
                'background_size' => $this->background_size,
                'front_size' => $this->front_size,
                'color' => $this->color,
            ]);

            DB::commit();

            session()->flash('success', 'Terreno editado com sucesso!');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao editar Terreno. Tente novamente.');
            throw $e;
        }
    }
}
