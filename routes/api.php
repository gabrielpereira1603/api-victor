<?php

use App\Http\Controllers\Api\Property\CreatePropertyController;
use App\Http\Controllers\Api\Property\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('properties')->group(function () {
        Route::post('/create', [CreatePropertyController::class, 'store'])->name('createProperties');
        Route::put('update/{id}', [PropertyController::class, 'update'])->name('updateProperty');
        Route::delete('delete/{id}', [PropertyController::class, 'delete'])->name('deleteProperty');
        Route::put('/restore/{id}', [PropertyController::class, 'restore'])->name('restoreProperty');
    });
});

Route::prefix('properties')->group(function () {
    Route::get('/all', [PropertyController::class, 'findAll'])->name('allProperties');
    Route::get('/one/{id}', [PropertyController::class, 'findOne'])->name('oneProperty');
});
