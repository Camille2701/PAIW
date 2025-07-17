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
        // Collection principale pour compatibilité
        $this->addMediaCollection('color_images')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
              ->useDisk('public');

        // Les collections dynamiques pour chaque couleur seront créées à la volée
        // avec les bonnes configurations de disque et chemin
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
        // Essayer d'abord la nouvelle approche avec collection séparée
        $media = $this->getMedia("color_{$colorId}")->first();

        if (!$media) {
            // Fallback vers l'ancienne approche avec customProperties
            $media = $this->getMedia('color_images')
                         ->where('custom_properties.color_id', $colorId)
                         ->first();
        }

        if ($media) {
            // Essayer d'abord la conversion demandée
            try {
                if ($media->hasGeneratedConversion($conversion)) {
                    return $media->getUrl($conversion);
                }
            } catch (\Exception $e) {
                // Ignore l'erreur et continue vers l'image originale
            }

            // Fallback vers l'image originale si la conversion n'existe pas
            return $media->getUrl();
        }

        // Retourner null si aucune image n'est trouvée
        return null;
    }

    /**
     * Vérifier si une couleur a une image
     */
    public function hasImageForColor($colorId)
    {
        // Vérifier les deux approches
        return $this->getMedia("color_{$colorId}")->isNotEmpty() ||
               $this->getMedia('color_images')
                   ->where('custom_properties.color_id', $colorId)
                   ->isNotEmpty();
    }

    /**
     * Obtenir l'image par défaut du produit (première couleur avec image disponible)
     */
    public function getDefaultImage($conversion = 'thumb')
    {
        // Récupérer toutes les couleurs disponibles pour ce produit
        $colors = $this->variants()->with('color')->get()->pluck('color')->unique('id');

        foreach ($colors as $color) {
            if ($this->hasImageForColor($color->id)) {
                return $this->getImageForColor($color->id, $conversion);
            }
        }

        // Si aucune image n'est trouvée, retourner null pour permettre un fallback CSS
        return null;
    }

    /**
     * Obtenir l'URL de l'image pour une couleur spécifique, avec fallback vers image par défaut
     */
    public function getImageUrl($colorId = null, $conversion = 'thumb')
    {
        if ($colorId && $this->hasImageForColor($colorId)) {
            return $this->getImageForColor($colorId, $conversion);
        }

        return $this->getDefaultImage($conversion);
    }

    /**
     * Vérifier si le produit a au moins une image
     */
    public function hasAnyImage()
    {
        $colors = $this->variants()->with('color')->get()->pluck('color')->unique('id');

        foreach ($colors as $color) {
            if ($this->hasImageForColor($color->id)) {
                return true;
            }
        }

        return false;
    }
}
