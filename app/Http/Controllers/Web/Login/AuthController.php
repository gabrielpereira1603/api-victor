<?php

namespace App\Http\Controllers\Web\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['login' => 'Credenciais inválidas.'])->withInput();
        }

        Auth::login($user);

        return redirect()->intended('/home');
    }

    public function logout(Request $request)
    {
        // Revogar todos os tokens do usuário autenticado (Sanctum)
        $request->user()->tokens()->delete();

        // Fazer logout utilizando o guard 'web'
        Auth::guard('web')->logout();

        // Invalidar a sessão atual
        $request->session()->invalidate();

        // Regenerar o token CSRF para segurança
        $request->session()->regenerateToken();

        // Redirecionar para a página de login
        return redirect()->route('loginView')->with('success', 'Você foi deslogado com sucesso.');
    }
}
