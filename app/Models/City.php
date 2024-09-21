<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'state_id'];

    protected $dates = ['deleted_at'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
