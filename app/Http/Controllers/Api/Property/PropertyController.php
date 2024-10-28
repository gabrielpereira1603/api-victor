<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Property;
use App\Traits\CRUDTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    use CRUDTrait;

    protected $model = Property::class;

    public function __construct()
    {
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'cidade' => 'nullable|string|max:255',
            'minValue' => 'nullable|numeric',
            'maxValue' => 'nullable|numeric',
            'bedrooms' => 'nullable|',
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
        if ($request->filled('bedrooms')) {
            if ($request->bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', '=', $request->bedrooms);
            }
        }

        $properties = $query->get();

        return response()->json($properties);
    }
}
