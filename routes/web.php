<?php

use App\Http\Controllers\Web\Home\CreatePropertyController;
use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Login\AuthController;
use App\Http\Controllers\Web\Login\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/properties', [CreatePropertyController::class, 'store'])->name('createPropertiesWEB');

});
