<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image_path',
        'start_date',
        'end_date',
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
