<?php

namespace App\Livewire\Components\Modals\Alerts;

use Livewire\Component;

class ConfirmModal extends Component
{
    public $modalId;
    public $title;
    public $message;
    public $confirmMethod;
    public $cancelMethod;

    protected $listeners = [
        'showConfirmModal' => 'open',
        'closeConfirmModal' => 'close',
    ];

    public $isOpen = false;

    public function open($params)
    {
        $this->modalId = $params['modalId'] ?? null;
        $this->title = $params['title'] ?? 'Confirmação';
        $this->message = $params['message'] ?? 'Tem certeza que deseja executar esta ação?';
        $this->confirmMethod = $params['confirmMethod'] ?? null;
        $this->cancelMethod = $params['cancelMethod'] ?? null;

        $this->isOpen = true;
    }

    public function close()
    {
        $this->reset();
        $this->isOpen = false;
    }

    public function confirm()
    {
        if ($this->confirmMethod) {
            $this->dispatch($this->confirmMethod, $this->modalId);
        }
        $this->close();
    }

    public function cancel()
    {
        if ($this->cancelMethod) {
            $this->dispatch($this->cancelMethod, $this->modalId);
        }
        $this->close();
    }

    public function render()
    {
        return view('livewire.components.modals.alerts.confirm-modal');
    }
}
