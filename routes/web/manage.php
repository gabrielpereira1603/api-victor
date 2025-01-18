<?php


use App\Livewire\Pages\Manage\Alerts\HomeAlertsManage;
use App\Livewire\Pages\Manage\HomeManage;
use Illuminate\Support\Facades\Route;

Route::prefix('manage')->middleware('auth')->group(function () {
    Route::get('/', HomeManage::class)->name('home.manage');


    Route::prefix('alerts')->group(function () {
        Route::get('/', HomeAlertsManage::class)->name('home.alerts');
    });
});


