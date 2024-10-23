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
        // Validação dos campos da requisição
        $request->validate([
            'cidade' => 'nullable|string|max:255',
            'minValue' => 'nullable|numeric',
            'maxValue' => 'nullable|numeric',
            'bedrooms' => 'nullable|',
        ]);
        // Inicializa a consulta na tabela de propriedades, já incluindo os relacionamentos
        $query = Property::with(['neighborhood', 'city', 'state']);

        // Filtro por cidade, se fornecido
        if ($request->filled('cidade')) {
            $city = City::where('name', 'LIKE', '%' . $request->cidade . '%')->first();
            if ($city) {
                $query->where('city_id', '=', $city->id);
            } else {
                // Se a cidade não for encontrada, não há propriedades para exibir
                return response()->json([]);
            }
        }

        // Filtro pelo valor mínimo
        if ($request->filled('minValue')) {
            $query->where('value', '>=', $request->minValue);
        }

        // Filtro pelo valor máximo
        if ($request->filled('maxValue')) {
            $query->where('value', '<=', $request->maxValue);
        }
        // Filtro por número de quartos
        if ($request->filled('bedrooms')) {
            if ($request->bedrooms === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', '=', $request->bedrooms);
            }
        }

        // Obtém as propriedades com os relacionamentos carregados
        $properties = $query->get();

        return response()->json($properties);
    }
}
