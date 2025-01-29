<?php

use App\Http\Controllers\Api\Property\CreatePropertyController;
use App\Http\Controllers\Api\Property\PropertyController;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::get('/cities/search', function (Request $request) {
    $query = $request->input('query');
    $cities = City::where('name', 'like', '%' . $query . '%')->get();
    return response()->json($cities);
});

require __DIR__.'/api/alerts.php';
require __DIR__.'/api/properties.php';
