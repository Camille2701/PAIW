<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    protected static function boot()
    {
        parent::boot();
        Model::unguard();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'street',
        'postal_code',
        'department',
        'country',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('avatar');

        $this->addMediaConversion('small')
            ->width(50)
            ->height(50)
            ->sharpen(10)
            ->performOnCollections('avatar');
    }

    public function getAvatarUrl()
    {
        $media = $this->getFirstMedia('avatar');
        if ($media) {
            // Utiliser l'URL native de Spatie Media Library
            return asset('storage/' . $media->id . '/' . $media->file_name);
        }

        // Avatar par défaut basé sur les initiales
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&size=50&background=6366f1&color=ffffff";
    }

    public function getAvatarThumbUrl()
    {
        $media = $this->getFirstMedia('avatar');
        if ($media) {
            // Utiliser l'URL native de Spatie Media Library
            return asset('storage/' . $media->id . '/' . $media->file_name);
        }

        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&size=150&background=6366f1&color=ffffff";
    }
}
