<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérifiez votre email - {{ config('app.name') }}</title>
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
        <h2>Vérification de votre adresse email</h2>

        <p>Bonjour {{ $user->first_name ?? 'Utilisateur' }},</p>

        <p>Merci de vous être inscrit(e) sur <strong>{{ config('app.name') }}</strong> !</p>

        <p>Pour finaliser la création de votre compte, veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email :</p>

        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">✅ Vérifier mon email</a>
        </div>

        <p>Si vous n'arrivez pas à cliquer sur le bouton, copiez et collez cette URL dans votre navigateur :</p>
        <p style="word-break: break-all;">{{ $verificationUrl }}</p>

        <p>Ce lien de vérification expirera dans {{ config('auth.verification.expire', 60) }} minutes.</p>

        <p>Si vous n'avez pas créé de compte sur notre site, aucune action n'est requise.</p>

        <p>Merci,<br>L'équipe {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        <p>Si vous rencontrez des problèmes pour cliquer sur le bouton, copiez et collez l'URL ci-dessus dans votre navigateur web.</p>
    </div>
</body>
</html>
