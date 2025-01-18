<?php

use App\Http\Controllers\Api\Property\PropertyController;
use App\Http\Controllers\Web\Property\PropertyImageController;
use App\Http\Controllers\Web\Property\UpdatePropertyController;
use App\Livewire\Pages\Properties\CreateProperties;
use App\Livewire\Pages\Properties\HomeProperties;
use App\Livewire\Pages\Properties\UpdateProperties;
use Illuminate\Support\Facades\Route;

Route::prefix('properties')->middleware('auth')->group(function () {
    Route::get('/', HomeProperties::class)->name('properties');
    Route::get('/create', CreateProperties::class)->name('properties.create');
    Route::get('/update/{property_id}', UpdateProperties::class)->name('properties.update');


    Route::patch('/{property}/disable', [PropertyController::class, 'disable'])->name('properties.disable');
    Route::patch('/{property}/restore', [PropertyController::class, 'restore'])->name('properties.restore');
    Route::delete('/{property}/force-delete', [PropertyController::class, 'forceDelete'])->name('properties.forceDelete');
});
