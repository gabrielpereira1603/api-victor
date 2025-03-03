<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'photo_url',
        'value',
        'bedrooms',
        'bathrooms',
        'living_rooms',
        'kitchens',
        'parking_spaces',
        'pools',
        'built_area',
        'land_area',
        'neighborhood_id',
        'city_id',
        'state_id',
        'written',
        'ramp',
        'machine_room',
        'description',
        'file_name',
        'file_type',
        'maps',
        'type_property_id',
    ];

    protected $dates = ['deleted_at'];

    public function typeProperty()
    {
        return $this->belongsTo(TypeProperty::class);
    }

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

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}
