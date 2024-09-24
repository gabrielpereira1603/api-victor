<?php

namespace App\Http\Controllers\Api\Property;

use App\Http\Controllers\Controller;
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
}
