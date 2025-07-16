<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductVariant extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'stock',
        'sku',
    ];

    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
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

    public function getImageUrl()
    {
        $image = $this->getFirstMedia('images');
        if ($image) {
            return $image->getUrl('thumb');
        }

        // Image par défaut basée sur la couleur du produit
        return "https://via.placeholder.com/300x300/" .
               str_replace('#', '', $this->color->hex_code ?? 'cccccc') .
               "/ffffff?text=" . urlencode($this->product->name ?? 'Product');
    }

    public function getLargeImageUrl()
    {
        $image = $this->getFirstMedia('images');
        if ($image) {
            return $image->getUrl('large');
        }

        return "https://via.placeholder.com/800x800/" .
               str_replace('#', '', $this->color->hex_code ?? 'cccccc') .
               "/ffffff?text=" . urlencode($this->product->name ?? 'Product');
    }
}
