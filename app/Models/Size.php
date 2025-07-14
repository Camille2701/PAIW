<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'label',
    ];


    // Accessor pour récupérer le nom de la taille
    public function getNameAttribute()
    {
        return $this->label;
    //Unguard pour accès à Filament
    protected static function boot()
    {
        parent::boot();
        Model::unguard();

    }
}
