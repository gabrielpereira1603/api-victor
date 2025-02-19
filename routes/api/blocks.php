<?php

use App\Http\Controllers\Api\Blocks\BlocksController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('blocks')->group(function () {
        Route::post('/create', [BlocksController::class, 'create'])->name('createBlocks');

    });
});
