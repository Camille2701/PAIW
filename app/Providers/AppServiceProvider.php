<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enregistrer le service du panier
        $this->app->singleton(\App\Services\CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuration de la locale
        app()->setLocale('fr');

        // Traduction des genres pour Filament
        \Illuminate\Support\Facades\Blade::directive('gender', function ($expression) {
            return "<?php echo __('gender.' . $expression); ?>";
        });
    }
}
