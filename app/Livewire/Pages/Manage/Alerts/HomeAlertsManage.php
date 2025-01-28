<?php

namespace App\Livewire\Pages\Manage\Alerts;

use App\Models\Alert;
use App\Models\TypeProperty;
use Carbon\Carbon;
use Livewire\Component;

class HomeAlertsManage extends Component
{
    public $activeAlerts = [];
    public $expiredAlerts = [];

    public function mount()
    {
        $today = Carbon::today();

        $this->activeAlerts = Alert::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereNull('deleted_at')
            ->get();

        $this->expiredAlerts = Alert::withTrashed()
        ->where(function ($query) use ($today) {
            $query->where('end_date', '<', $today)
            ->orWhereNotNull('deleted_at');
        })
            ->get();
    }
    public function deactivateAlert($alertId)
    {
        $alert = Alert::find($alertId);

        if ($alert) {
            $alert->delete();
            session()->flash('success', 'Alerta desativado com sucesso!');
            $this->mount();
        } else {
            session()->flash('error', 'Alerta não encontrado.');
        }
    }

    public function render()
    {
        return view('livewire.pages.manage.alerts.home-alerts-manage')->layout('layouts.app');
    }
}
