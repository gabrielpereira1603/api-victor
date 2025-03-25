<?php

namespace App\Livewire\Forms\Lands;

use App\Models\Blocks;
use App\Models\Lands;
use App\Models\Subdivision;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateLandsForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:255')]
    public $code;

    #[Validate('required|nullable|array')]
    public $coordinates = [];

    #[Validate('required|in:Disponível,Reservado,Indisponível')]
    public $status = 'Disponível';

    #[Validate('required|numeric|min:0')]
    public $area;

    #[Validate('required|numeric|min:0')]
    public $front_size;

    #[Validate('required|numeric|min:0')]
    public $background_size;

    public $color;

    public $lands;

    #[Validate('required')]
    public $blocks;

    public Subdivision $subdivision;

    public $block_id;

    public function store($first_coordinate)
    {
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
            $lands = Lands::create([
                'block_id' => $this->blocks,
                'name' => $this->name,
                'code' => $this->code,
                'coordinates' => json_encode($this->coordinates),
                'first_coordinate' => $first_coordinate,
                'status' => $this->status,
                'area' => $this->area,
                'front_size' => $this->front_size,
                'background_size' => $this->background_size,
                'color' => $this->color,
            ]);

            DB::commit();

            session()->flash('success', 'Terreno cadastrado com sucesso!');
            return redirect()->route('subdivision.view_one', ['subdivision_id' => $this->subdivision->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar Terreno. Tente novamente.');
            throw $e;
        }
    }


}
