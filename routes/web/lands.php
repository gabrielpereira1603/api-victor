<?php

use App\Livewire\Pages\Lands\CreateLands;
use Illuminate\Support\Facades\Route;

Route::prefix('lands')->middleware('auth')->group(function () {
    Route::get('/create/{subdivision_id}', CreateLands::class)->name('lands.create');

});

