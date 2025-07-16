<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomePageSettings extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'homepage_settings';

    // Pas de timestamps car on utilise un seul enregistrement statique
    public $timestamps = false;

    protected $fillable = [];

    public static function instance()
    {
        // Retourner l'instance unique (ID 1) ou la créer si elle n'existe pas
        return static::firstOrCreate(['id' => 1]);
    }

    public static function getHeroImageUrl()
    {
        return static::instance()->getFirstMediaUrl('homepage-hero');
    }

    public static function getPromotionImageUrl()
    {
        return static::instance()->getFirstMediaUrl('homepage-promotion');
    }

    public static function setHeroImage($file)
    {
        $instance = static::instance();

        // Supprimer l'ancienne image
        $instance->clearMediaCollection('homepage-hero');

        // Ajouter la nouvelle image
        if (is_string($file)) {
            // Si c'est un chemin de fichier
            $instance->addMediaFromUrl(asset('storage/' . $file))
                ->toMediaCollection('homepage-hero');
        } else {
            // Si c'est un UploadedFile
            $instance->addMediaFromRequest('hero_image')
                ->toMediaCollection('homepage-hero');
        }

        return $instance;
    }

    public static function setPromotionImage($file)
    {
        $instance = static::instance();

        // Supprimer l'ancienne image
        $instance->clearMediaCollection('homepage-promotion');

        // Ajouter la nouvelle image
        if (is_string($file)) {
            // Si c'est un chemin de fichier
            $instance->addMediaFromUrl(asset('storage/' . $file))
                ->toMediaCollection('homepage-promotion');
        } else {
            // Si c'est un UploadedFile
            $instance->addMediaFromRequest('promotion_image')
                ->toMediaCollection('homepage-promotion');
        }

        return $instance;
    }
}
