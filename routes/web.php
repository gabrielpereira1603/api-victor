<?php

use App\Http\Controllers\Web\Home\CreatePropertyController;
use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Login\AuthController;
use App\Http\Controllers\Web\Login\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // Redirecionar para 'home' se o usuário estiver autenticado
    } else {
        return redirect()->route('loginView'); // Redirecionar para 'login' se não estiver autenticado
    }
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/properties', [CreatePropertyController::class, 'store'])->name('createPropertiesWEB');

});
