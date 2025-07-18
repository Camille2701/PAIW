<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $statusInfo['title'] }} - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid {{ $statusInfo['color'] }};
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .status-banner {
            background-color: {{ $statusInfo['color'] }};
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .status-banner h2 {
            margin: 0;
            font-size: 24px;
        }
        .status-banner p {
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: {{ $statusInfo['color'] }};
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="status-banner">
            <h2>{{ $statusInfo['title'] }}</h2>
            <p>{{ $statusInfo['message'] }}</p>
        </div>

        <div class="order-info">
            <h3>📦 Détails de la commande</h3>
            <p><strong>Numéro de commande :</strong> #{{ $order->id }}</p>
            <p><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Nouveau statut :</strong>
                @php
                    $statusTranslations = [
                        'pending' => 'En attente',
                        'paid' => 'Payée',
                        'processing' => 'En préparation',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'cancelled' => 'Annulée'
                    ];
                @endphp
                {{ $statusTranslations[$newStatus] ?? ucfirst($newStatus) }}
            </p>
        </div>

        @if($order->status == 'shipped')
        <div style="text-align: center; margin: 30px 0; background-color: #d1ecf1; padding: 20px; border-radius: 5px; color: #0c5460;">
            <h3>🚚 Votre commande est en route !</h3>
            <p>Votre commande a été expédiée et devrait arriver dans les prochains jours selon le mode de livraison choisi.</p>
            @if($order->tracking_number)
            <p><strong>Numéro de suivi :</strong> {{ $order->tracking_number }}</p>
            @endif
        </div>
        @endif

        @if($order->status == 'delivered')
        <div style="text-align: center; margin: 30px 0; background-color: #d4edda; padding: 20px; border-radius: 5px; color: #155724;">
            <h3>🎉 Commande livrée avec succès !</h3>
            <p>Nous espérons que vous êtes satisfait(e) de votre commande. N'hésitez pas à nous laisser un avis !</p>
        </div>
        @endif

        @if($order->status == 'cancelled')
        <div style="text-align: center; margin: 30px 0; background-color: #f8d7da; padding: 20px; border-radius: 5px; color: #721c24;">
            <h3>❌ Commande annulée</h3>
            <p>Votre commande a été annulée. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
            @if($order->total_price > 0)
            <p><strong>Le remboursement sera traité dans les prochains jours.</strong></p>
            @endif
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('home') }}" class="btn">Retour à la boutique</a>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Pour toute question, contactez-nous à {{ config('mail.from.address') }}</p>
            <p><em>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</em></p>
        </div>
    </div>
</body>
</html>
