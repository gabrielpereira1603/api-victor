<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blocks extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'subdivision_id',
        'coordinates',
        'status',
        'area',
        'color',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function subdivision()
    {
        return $this->belongsTo(Subdivision::class, 'subdivision_id');
    }

    public function lands()
    {
        return $this->hasMany(Lands::class, 'block_id');
    }
}
