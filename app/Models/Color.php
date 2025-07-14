<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'hex_code',
    ];

    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }
}
