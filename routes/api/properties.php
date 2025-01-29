<?php

use App\Http\Controllers\Api\Property\CreatePropertyController;
use App\Http\Controllers\Api\Property\PropertyController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('properties')->group(function () {
        Route::post('/create', [CreatePropertyController::class, 'store'])->name('createProperties');
        Route::put('update/{id}', [PropertyController::class, 'update'])->name('updateProperty');
        Route::delete('delete/{id}', [PropertyController::class, 'delete'])->name('deleteProperty');
        Route::put('/restore/{id}', [PropertyController::class, 'restore'])->name('restoreProperty');
    });
});

Route::prefix('properties')->group(function () {
    Route::get('/all', [PropertyController::class, 'findAll'])->name('allProperties');
    Route::get('/{id}', [PropertyController::class, 'findOneProperties'])->name('oneProperty');
    Route::post('/search', [PropertyController::class, 'search']);
});
