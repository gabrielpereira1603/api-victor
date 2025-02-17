<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lands extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'block_id',
        'coordinates',
        'status',
        'area',
        'color',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    protected $dates = ['deleted_at'];


    public function blocks()
    {
        return $this->belongsTo(Blocks::class, 'block_id');
    }
}
