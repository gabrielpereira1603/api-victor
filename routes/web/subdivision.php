<?php

use App\Livewire\Pages\Properties\CreateProperties;
use App\Livewire\Pages\Subdivisions\CreateSubdivisions;
use App\Livewire\Pages\Subdivisions\HomeSubdivisions;
use App\Livewire\Pages\Subdivisions\Manage\ManageBloks;
use App\Livewire\Pages\Subdivisions\Manage\ManageSubdivisions;
use App\Livewire\Pages\Subdivisions\ViewOneSubdivision;
use Illuminate\Support\Facades\Route;

Route::prefix('subdivision')->middleware('auth')->group(function () {
    Route::get('/', HomeSubdivisions::class)->name('subdivision');
    Route::get('/create', CreateSubdivisions::class)->name('subdivision.create');
    Route::get('/view_one/{subdivision_id}', ViewOneSubdivision::class)->name('subdivision.view_one');


    Route::prefix('manage')->group(function () {
        Route::get('/{subdivision_id}', ManageSubdivisions::class)->name('subdivision.manage');
        Route::get('/blocks/{subdivision_id}', ManageBloks::class)->name('subdivision.blocks.manage');
    });
});

