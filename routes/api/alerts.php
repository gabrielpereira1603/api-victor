<?php

use App\Http\Controllers\Api\Alerts\AlertController;
use Illuminate\Support\Facades\Route;

Route::prefix('alerts')->group(function () {
    Route::get('/all', [AlertController::class, 'findAll'])->name('allAlerts');
});
