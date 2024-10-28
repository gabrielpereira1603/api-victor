<?php

namespace App\Http\Controllers\Web\Property;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['neighborhood', 'city', 'state'])->withTrashed()->get();
        return view('properties', compact('properties'));
    }

    public function indexCreate()
    {
        $properties = Property::with(['neighborhood', 'city', 'state'])->withTrashed()->get();
        return view('properties.create', compact('properties'));
    }

    public function disable(Property $property)
    {
        $property->delete();
        return redirect()->route('properties')->with('status', 'Propriedade desativada com sucesso!');
    }

    public function restore($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->restore();
        return redirect()->route('properties')->with('status', 'Propriedade reativada com sucesso!');
    }

    public function forceDelete($id)
    {
        $property = Property::withTrashed()->findOrFail($id);
        $property->forceDelete();
        return redirect()->route('properties')->with('status', 'Propriedade excluída definitivamente com sucesso!');
    }
}
