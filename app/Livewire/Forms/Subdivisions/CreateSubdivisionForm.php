<?php

namespace App\Livewire\Forms\Subdivisions;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\State;
use App\Models\Subdivision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSubdivisionForm extends Form
{
    #[Validate('required|string|max:122')]
    public $city;

    #[Validate('required|string|max:122')]
    public $neighborhood;

    #[Validate('required|string|max:122')]
    public $state;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('nullable|array')]
    public $coordinates = [];

    #[Validate('required|in:active,inactive')]
    public $status = 'active';

    #[Validate('nullable|numeric|min:0')]
    public $area;

    #[Validate('nullable|string|max:255')]
    public $color = '#000000';

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->state = State::firstOrCreate(
                ['slug' => Str::slug($this->state),
                    'name' => $this->state]
            );

            $this->city = City::firstOrCreate(
                [
                    'slug' => Str::slug($this->city),
                    'name' => $this->city,
                    'state_id' => $this->state->id
                ]
            );

            $this->neighborhood = Neighborhood::firstOrCreate(
                [
                    'slug' => Str::slug($this->neighborhood),
                    'name' => $this->neighborhood,
                    'city_id' => $this->city->id
                ]
            );
            $subdivision = Subdivision::create([
                'city_id' => $this->city->id,
                'neighborhood_id' => $this->neighborhood->id,
                'state_id' => $this->state->id,
                'name' => $this->name,
                'coordinates' => $this->coordinates ? json_encode($this->coordinates) : null,
                'status' => $this->status,
                'area' => $this->area,
                'color' => $this->color,
            ]);

            DB::commit();

            session()->flash('success', 'Loteamento cadastrado com sucesso!');
            return redirect()->to('/subdivision');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar loteamento. Tente novamente.');
            throw $e;
        }

    }
}
