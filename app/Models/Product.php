<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'product_type_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);

                // Vérifier l'unicité et ajouter un suffixe si nécessaire
                $originalSlug = $product->slug;
                $counter = 1;
                while (static::where('slug', $product->slug)->exists()) {
                    $product->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
            Model::unguard();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('color_images')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(300)
              ->height(300)
              ->sharpen(10);

        $this->addMediaConversion('large')
              ->width(800)
              ->height(800)
              ->sharpen(10);
    }

    /**
     * Obtenir l'image pour une couleur spécifique
     */
    public function getImageForColor($colorId, $conversion = 'thumb')
    {
        $media = $this->getMedia('color_images')
                     ->where('custom_properties.color_id', $colorId)
                     ->first();

        if ($media) {
            return $media->getUrl($conversion);
        }

        // Image par défaut si aucune image n'est trouvée
        $color = \App\Models\Color::find($colorId);
        $hexCode = $color ? str_replace('#', '', $color->hex_code) : 'cccccc';

        return "https://via.placeholder.com/300x300/{$hexCode}/ffffff?text=" . urlencode($this->name);
    }

    /**
     * Obtenir toutes les couleurs qui ont des images
     */
    public function getColorsWithImages()
    {
        return $this->getMedia('color_images')
                   ->pluck('custom_properties.color_id')
                   ->unique()
                   ->filter();
    }

    /**
     * Vérifier si une couleur a une image
     */
    public function hasImageForColor($colorId)
    {
        return $this->getMedia('color_images')
                   ->where('custom_properties.color_id', $colorId)
                   ->isNotEmpty();
    }
}
