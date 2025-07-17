<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;
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
