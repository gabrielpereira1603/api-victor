<?php

use App\Http\Controllers\Api\Subdivisions\SubdivisionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('subdivisions')->group(function () {
        Route::post('/create', [SubdivisionController::class, 'store'])->name('createSubdivisions');

    });
});
