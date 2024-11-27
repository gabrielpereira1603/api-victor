<?php

use App\Http\Controllers\Web\Property\PropertyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Property\PropertyImageController;
use App\Http\Controllers\Web\Property\UpdatePropertyController;
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

    Route::get('/{property}/update', [UpdatePropertyController::class, 'index'])->name('properties.update');
    Route::patch('/{property}', [UpdatePropertyController::class, 'update'])->name('properties.update.submit');
    Route::delete('/{property}/photo', [UpdatePropertyController::class, 'deletePhoto'])->name('properties.photo.delete');

    Route::patch('/{property}/disable', [PropertyController::class, 'disable'])->name('properties.disable');
    Route::patch('/{property}/restore', [PropertyController::class, 'restore'])->name('properties.restore');
    Route::delete('/{property}/force-delete', [PropertyController::class, 'forceDelete'])->name('properties.forceDelete');

    Route::post('/properties/{property}/photos', [PropertyImageController::class, 'store'])->name('properties.photos.store');
    Route::delete('/properties/photos/{photo}', [PropertyImageController::class, 'destroy'])->name('properties.photos.destroy');
    Route::delete('properties/{propertyId}/photos/clear', [PropertyImageController::class, 'clearAllPhotos'])->name('properties.photos.clear');

});
require __DIR__.'/auth.php';
