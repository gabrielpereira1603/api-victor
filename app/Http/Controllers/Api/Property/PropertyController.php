<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Property;
use App\Traits\CRUDTrait;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use CRUDTrait;

    protected $model = Property::class;

    public function __construct()
    {
    }

    public function search(Request $request)
    {
        $request->validate([
            'cidade' => 'nullable|string|max:255',
            'minValue' => 'nullable|string',
            'maxValue' => 'nullable|string',
            'quartos' => 'nullable|string|in:1,2,3,4,5+',
        ]);

        $query = Property::with(['neighborhood', 'city', 'state']);

        if ($request->filled('cidade')) {
            $city = City::where('name', 'LIKE', '%' . $request->cidade . '%')->first();
            if ($city) {
                $query->where('city_id', '=', $city->id);
            } else {
                return response()->json([]);
            }
        }

        if ($request->filled('minValue')) {
            $query->where('value', '>=', $request->minValue);
        }

        if ($request->filled('maxValue')) {
            $query->where('value', '<=', $request->maxValue);
        }

        if ($request->filled('quartos')) {
            $query->where('bedrooms', '=', $request->quartos);
        }

        // Obtém as propriedades com os relacionamentos carregados
        $properties = $query->get();

        return response()->json($properties);
    }
}
