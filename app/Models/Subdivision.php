<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdivision extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'neighborhood_id',
        'state_id',
        'name',
        'coordinates',
        'status',
        'area',
        'color',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function blocks()
    {
        return $this->hasMany(Blocks::class, 'subdivision_id');
    }
}
