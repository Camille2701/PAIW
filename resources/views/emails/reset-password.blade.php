<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialisation mot de passe - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .content {
            padding: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #000;
            color: #fff !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>

    <div class="content">
        <h2>Réinitialisation de votre mot de passe</h2>

        <p>Bonjour {{ $user->first_name ?? 'Utilisateur' }},</p>

        <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte sur <strong>{{ config('app.name') }}</strong>.</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="button">🔒 Réinitialiser mon mot de passe</a>
        </div>

        <p>Ce lien de réinitialisation de mot de passe expirera dans {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.</p>

        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise. Votre mot de passe actuel reste inchangé.</p>

        <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        <p>Si vous rencontrez des problèmes pour cliquer sur le bouton, copiez et collez l'URL ci-dessous dans votre navigateur web : {{ $url }}</p>
    </div>
</body>
</html>
