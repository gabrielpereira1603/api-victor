<?php

namespace App\Livewire\Components\Modals;

use App\Livewire\Forms\Manage\Alerts\CreateAlertForm;
use App\Livewire\Forms\Manage\TypeProperties\CreateTypePropertiesForm;
use App\Models\Alert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateAlertModal extends Component
{
    public CreateAlertForm $form;

    use WithFileUploads;

    public $occupiedDates = [];

    public function mount()
    {
        $this->occupiedDates = Alert::select('start_date', 'end_date')
            ->get()
            ->flatMap(function ($alert) {
                $period = [];
                $start = new \DateTime($alert->start_date);
                $end = new \DateTime($alert->end_date);

                while ($start <= $end) {
                    $period[] = $start->format('Y-m-d');
                    $start->modify('+1 day');
                }

                return $period;
            })
            ->unique()
            ->values()
            ->toArray();

        // Enviar as datas ocupadas para o frontend
        $this->dispatch('set-occupied-dates', $this->occupiedDates);

    }

    public function save()
    {
        try {
            $this->form->store();
            session()->flash('success', 'Alerta salva com sucesso!');
            return $this->redirect('/manage');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validationFailed');
            throw $e;
        }
    }
    public function render()
    {

        return view('livewire.components.modals.create-alert-modal')->layout('layouts.app');
    }
}
