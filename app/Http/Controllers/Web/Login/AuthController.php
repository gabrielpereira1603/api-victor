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
            return response()->json(['error' => 'Credenciais inválidas.'], 401);
        }

        Auth::login($user);

        $token = $user->createToken('loginToken')->plainTextToken;

        return redirect()->intended('/home');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Auth::logout();

        return response()->json(['message' => 'Usuário deslogado.']);
    }
}
