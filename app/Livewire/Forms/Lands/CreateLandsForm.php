<?php

namespace App\Livewire\Forms\Lands;

use App\Models\Blocks;
use App\Models\Lands;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateLandsForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:255')]
    public $code;

    #[Validate('nullable|array')]
    public $coordinates = [];

    #[Validate('required|in:active,inactive')]
    public $status = 'active';

    #[Validate('nullable|numeric|min:0')]
    public $area;

    #[Validate('nullable|string|max:255')]
    public $color = '#000000';

    public $lands;

    public $blocks;

    public $subdivision;

    public $block_id;

    public function store()
    {

        $this->validate();
        DB::beginTransaction();

        try {

            $lands = Lands::create([
                'block_id' => $this->block_id,
                'name' => $this->name,
                'code' => $this->code,
                'coordinates' => $this->coordinates ? json_encode($this->coordinates) : null,
                'status' => $this->status,
                'area' => $this->area,
                'color' => $this->color,
            ]);

            DB::commit();

            session()->flash('success', 'Terreno cadastrado com sucesso!');
            return redirect()->to('/view_one/' . $this->subdivision->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar Terreno. Tente novamente.');
            throw $e;
        }

    }

}
