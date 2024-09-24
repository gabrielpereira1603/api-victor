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
        $request->user()->tokens()->delete();

        Auth::logout();

        return response()->json(['message' => 'Usuário deslogado.']);
    }
}
