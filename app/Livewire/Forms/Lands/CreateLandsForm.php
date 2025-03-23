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

    #[Validate('required|in:active,inactive')]
    public $status = 'active';

    #[Validate('nullable|numeric|min:0')]
    public $area;

    public $color = '';

    public $lands;

    #[Validate('required')]
    public $blocks;

    public Subdivision $subdivision;

    public $block_id;

    public function store($first_coordinate)
    {
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
