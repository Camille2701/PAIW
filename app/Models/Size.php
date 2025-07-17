<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'label',
    ];


    // Accessor pour récupérer le nom de la taille
    public function getNameAttribute()
    {
        return $this->label;
    }

    // Unguard pour accès à Filament
    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }
}
