<?php

namespace App\Http\Controllers\Web\Property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('property.index', ['user' => $user]);
    }
}
