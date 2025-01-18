<?php

namespace App\Livewire\Pages\Manage;

use Livewire\Component;

class HomeManage extends Component
{
    public function render()
    {
        return view('livewire.pages.manage.home-manage')
            ->layout('layouts.app');
    }
}
