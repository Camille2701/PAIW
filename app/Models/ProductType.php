<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    protected $fillable = [
        'name',
        'gender',
    ];

    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
