<?php

namespace App\Livewire\Forms\Manage\Alerts;

use App\Models\Alert;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateAlertForm extends Form
{
    use WithFileUploads;

    #[Validate('required|image|max:2048')]
    public $image_path;

    #[Validate('required|date')]
    public $start_date;

    #[Validate('required|date|after_or_equal:start_date')]
    public $end_date;


    public function validateDateOverlap()
    {
        $overlap = \App\Models\Alert::where(function ($query) {
            $query->where(function ($q) {
                $q->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            });
        })->exists();

        if ($overlap) {
            $this->addError('end_date', 'Já existe um alerta cadastrado para o período informado.');
        }
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $this->validateDateOverlap();

            $imagePath = $this->image_path->store('alerts_images', 'public');
            $this->image_path = asset('storage/' . $imagePath);

            Alert::create([
                'image_path' => $this->image_path,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);

            DB::commit();

            $this->reset(['image_path', 'start_date', 'end_date']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('form', 'Ocorreu um erro ao tentar salvar o alerta. Tente novamente.');
            throw $e;
        }
    }


}
