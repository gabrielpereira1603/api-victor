<?php

use App\Livewire\Pages\Blocks\CreateBlocks;
use Illuminate\Support\Facades\Route;

Route::prefix('blocks')->middleware('auth')->group(function () {
    Route::get('/create/{subdivision_id}', CreateBlocks::class)->name('blocks.create');

});

