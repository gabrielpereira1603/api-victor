<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'image_url',
    ];

    protected $dates = ['deleted_at'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
