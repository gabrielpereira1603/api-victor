<?php

use App\Http\Controllers\Web\Property\PropertyController;
use App\Http\Controllers\ProfileController;
use App\Models\Property;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('properties')->middleware('auth')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])->name('properties');
    Route::get('/create', [PropertyController::class, 'indexCreate'])->name('properties.create');
    Route::post('/store', [PropertyController::class, 'store'])->name('properties.store');
    Route::patch('/{property}/disable', [PropertyController::class, 'disable'])->name('properties.disable');
    Route::patch('/{property}/restore', [PropertyController::class, 'restore'])->name('properties.restore');
    Route::delete('/{property}/force-delete', [PropertyController::class, 'forceDelete'])->name('properties.forceDelete');
    // Rota para exibir as fotos de uma propriedade específica
    Route::get('/properties/{property}/photos', [PropertyController::class, 'editPhotos'])->name('properties.photos');

// Rota para adicionar fotos
    Route::post('/properties/{property}/photos', [PropertyController::class, 'storePhotos'])->name('properties.photos.store');

});
require __DIR__.'/auth.php';
