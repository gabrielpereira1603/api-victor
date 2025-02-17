<?php

namespace App\Livewire\Forms\Blocks;

use App\Models\Blocks;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\State;
use App\Models\Subdivision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateBlocksForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|string|max:255')]
    public $code;

    public $subdivision;

    #[Validate('nullable|array')]
    public $coordinates = [];

    #[Validate('required|in:active,inactive')]
    public $status = 'active';

    #[Validate('nullable|numeric|min:0')]
    public $area;

    #[Validate('nullable|string|max:255')]
    public $color = '#000000';

    public $blocks;

    public function store()
    {

        $this->validate();

        DB::beginTransaction();

        try {

            $blocks = Blocks::create([
                'subdivision_id' => $this->subdivision->id,
                'name' => $this->name,
                'code' => $this->code,
                'coordinates' => $this->coordinates ? json_encode($this->coordinates) : null,
                'status' => $this->status,
                'area' => $this->area,
                'color' => $this->color,
            ]);
            DB::commit();

            session()->flash('success', 'Quarteirão cadastrado com sucesso!');
            return redirect()->to('/view_one/' . $this->subdivision->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar Quarteirão. Tente novamente.');
            throw $e;
        }

    }

}
