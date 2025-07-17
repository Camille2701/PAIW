<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutPage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'about_page_settings';

    // Pas de timestamps car on utilise un seul enregistrement statique
    public $timestamps = false;

    protected $fillable = ['id'];

    public static function instance()
    {
        // Retourner l'instance unique (ID 1) ou la créer si elle n'existe pas
        return static::firstOrCreate(['id' => 1]);
    }

    public static function getAlexisImageUrl()
    {
        return static::instance()->getFirstMediaUrl('about-alexis');
    }

    public static function getCamilleImageUrl()
    {
        return static::instance()->getFirstMediaUrl('about-camille');
    }

    public static function getClementImageUrl()
    {
        return static::instance()->getFirstMediaUrl('about-clement');
    }

    public static function setAlexisImage($file)
    {
        $instance = static::instance();

        // Supprimer l'ancienne image
        $instance->clearMediaCollection('about-alexis');

        // Ajouter la nouvelle image
        if (is_string($file)) {
            // Si c'est un chemin de fichier
            $instance->addMediaFromUrl(asset('storage/' . $file))
                ->toMediaCollection('about-alexis');
        } else {
            // Si c'est un UploadedFile
            $instance->addMediaFromRequest('alexis_image')
                ->toMediaCollection('about-alexis');
        }

        return $instance;
    }

    public static function setCamilleImage($file)
    {
        $instance = static::instance();

        // Supprimer l'ancienne image
        $instance->clearMediaCollection('about-camille');

        // Ajouter la nouvelle image
        if (is_string($file)) {
            // Si c'est un chemin de fichier
            $instance->addMediaFromUrl(asset('storage/' . $file))
                ->toMediaCollection('about-camille');
        } else {
            // Si c'est un UploadedFile
            $instance->addMediaFromRequest('camille_image')
                ->toMediaCollection('about-camille');
        }

        return $instance;
    }

    public static function setClementImage($file)
    {
        $instance = static::instance();

        // Supprimer l'ancienne image
        $instance->clearMediaCollection('about-clement');

        // Ajouter la nouvelle image
        if (is_string($file)) {
            // Si c'est un chemin de fichier
            $instance->addMediaFromUrl(asset('storage/' . $file))
                ->toMediaCollection('about-clement');
        } else {
            // Si c'est un UploadedFile
            $instance->addMediaFromRequest('clement_image')
                ->toMediaCollection('about-clement');
        }

        return $instance;
    }
}
