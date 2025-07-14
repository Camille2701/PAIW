<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }
}
