<?php

namespace App\Http\Controllers\Web\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }
}
