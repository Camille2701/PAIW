<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

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

        // Configuration des emails personnalisés
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->view('emails.verify-email', [
                    'user' => $notifiable,
                    'verificationUrl' => $url,
                ])
                ->subject('Vérifiez votre adresse email - ' . config('app.name'));
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->view('emails.reset-password', [
                    'user' => $notifiable,
                    'url' => $url,
                ])
                ->subject('Réinitialisation de votre mot de passe - ' . config('app.name'));
        });

        // Écouter l'événement de connexion pour fusionner les paniers
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\MergeSessionCart::class
        );
    }
}
