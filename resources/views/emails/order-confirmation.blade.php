<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmation de commande - {{ config('app.name') }}</title>
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
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .product-item:last-child {
            border-bottom: none;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .product-details {
            flex: 1;
        }
        .product-name {
            font-weight: bold;
            color: #000;
        }
        .product-variant {
            color: #666;
            font-size: 14px;
        }
        .product-price {
            font-weight: bold;
            color: #000;
        }
        .total-section {
            background-color: #000;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .total-final {
            font-size: 18px;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        .shipping-info {
            background-color: #f8f9fa;
            padding: 15px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <h2>🎉 Merci pour votre commande !</h2>
        </div>

        <div class="order-info">
            <h3>📦 Détails de la commande</h3>
            <p><strong>Numéro de commande :</strong> #{{ $order->id }}</p>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <div>
            <h3>🛍️ Vos articles</h3>
            @foreach($order->orderItems as $item)
                <div class="product-item">
                    @if($item->productVariant && $item->productVariant->getFirstMediaUrl('images'))
                        <img src="{{ $item->productVariant->getFirstMediaUrl('images') }}"
                             alt="{{ $item->productVariant->product->name }}"
                             class="product-image">
                    @else
                        <div style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: #999;">
                            📷
                        </div>
                    @endif

                    <div class="product-details">
                        <div class="product-name">{{ $item->productVariant->product->name ?? 'Produit' }}</div>
                        <div class="product-variant">
                            @if($item->productVariant)
                                Couleur: {{ $item->productVariant->color->name ?? 'N/A' }} |
                                Taille: {{ $item->productVariant->size->name ?? 'N/A' }} |
                                Quantité: {{ $item->quantity }}
                            @endif
                        </div>
                        <div class="product-price">{{ number_format($item->unit_price, 2) }}€ × {{ $item->quantity }}</div>
                    </div>

                    <div style="text-align: right;">
                        <div class="product-price">{{ number_format($item->unit_price * $item->quantity, 2) }}€</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total-section">
            <h3 style="margin-top: 0;">💰 Récapitulatif</h3>
            <div class="total-row">
                <span>Sous-total :</span>
                <span>{{ number_format($order->total_price - $order->shipping_price + $order->discount_amount, 2) }}€</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="total-row">
                    <span>Réduction ({{ $order->coupon_code }}) :</span>
                    <span>-{{ number_format($order->discount_amount, 2) }}€</span>
                </div>
            @endif
            <div class="total-row">
                <span>Livraison ({{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}) :</span>
                <span>{{ number_format($order->shipping_price, 2) }}€</span>
            </div>
            <div class="total-row total-final">
                <span>TOTAL :</span>
                <span>{{ number_format($order->total_price, 2) }}€</span>
            </div>
        </div>

        <div class="shipping-info">
            <h3>🚚 Adresse de livraison</h3>
            <p>
                {{ $order->first_name }} {{ $order->last_name }}<br>
                {{ $order->street }}<br>
                @if($order->apartment){{ $order->apartment }}<br>@endif
                {{ $order->postal_code }} {{ $order->city }}<br>
                {{ $order->country }}
            </p>
            <p><strong>Email :</strong> {{ $order->email }}</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <p>📄 <strong>Votre facture est en pièce jointe de cet email.</strong></p>
        </div>

        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; text-align: center;">
            <h3>🎉 Merci pour votre confiance !</h3>
            <p>Nous préparons votre commande avec soin. Vous recevrez un email de suivi dès l'expédition.</p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
            <p>Pour toute question, contactez-nous à {{ config('mail.from.address') }}</p>
        </div>
    </div>
</body>
</html>
