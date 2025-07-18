<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $order->id }} - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-number {
            font-size: 18px;
            font-weight: bold;
        }
        .section {
            margin: 20px 0;
        }
        .billing-info {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }
        .billing-box {
            width: 45%;
        }
        .billing-box h3 {
            background-color: #f5f5f5;
            padding: 10px;
            margin: 0;
            border: 1px solid #ddd;
        }
        .billing-box div {
            padding: 15px 10px;
            border: 1px solid #ddd;
            border-top: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 30px;
            border-top: 2px solid #000;
            padding-top: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .total-final {
            font-size: 16px;
            font-weight: bold;
            background-color: #000;
            color: #fff;
            padding: 10px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">{{ config('app.name') }}</div>
        <div class="invoice-title">
            <div class="invoice-number">FACTURE #{{ $order->id }}</div>
            <div>Date: {{ $order->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="billing-info">
        <div class="billing-box">
            <h3>Facturation</h3>
            <div>
                <strong>{{ config('app.name') }}</strong><br>
                Adresse de votre entreprise<br>
                Code postal, Ville<br>
                Pays<br>
                SIRET: XXXXXXXXXXXXX
            </div>
        </div>

        <div class="billing-box">
            <h3>Livraison</h3>
            <div>
                {{ $order->first_name }} {{ $order->last_name }}<br>
                {{ $order->street }}<br>
                @if($order->apartment){{ $order->apartment }}<br>@endif
                {{ $order->postal_code }} {{ $order->city }}<br>
                {{ $order->country }}<br>
                Email: {{ $order->email }}
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Détails de la commande</h3>
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Détails</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-right">Prix unitaire</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->productVariant->product->name ?? 'Produit' }}</td>
                    <td>
                        @if($item->productVariant)
                            Couleur: {{ $item->productVariant->color->name ?? 'N/A' }}<br>
                            Taille: {{ $item->productVariant->size->name ?? 'N/A' }}
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}€</td>
                    <td class="text-right">{{ number_format($item->unit_price * $item->quantity, 2) }}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <div style="width: 50%; margin-left: auto;">
            <div class="total-row">
                <span>Sous-total HT:</span>
                <span>{{ number_format(($order->total_price - $order->shipping_price + $order->discount_amount) / 1.20, 2) }}€</span>
            </div>
            <div class="total-row">
                <span>TVA (20%):</span>
                <span>{{ number_format(($order->total_price - $order->shipping_price + $order->discount_amount) * 0.20 / 1.20, 2) }}€</span>
            </div>
            <div class="total-row">
                <span>Sous-total TTC:</span>
                <span>{{ number_format($order->total_price - $order->shipping_price + $order->discount_amount, 2) }}€</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="total-row">
                <span>Réduction ({{ $order->coupon_code }}):</span>
                <span>-{{ number_format($order->discount_amount, 2) }}€</span>
            </div>
            @endif
            <div class="total-row">
                <span>Livraison TTC:</span>
                <span>{{ number_format($order->shipping_price, 2) }}€</span>
            </div>
            <div class="total-final">
                <div class="total-row" style="margin: 0;">
                    <span>TOTAL TTC:</span>
                    <span>{{ number_format($order->total_price, 2) }}€</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Informations de livraison</h3>
        <p><strong>Mode de livraison:</strong> {{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}</p>
        <p><strong>Statut de la commande:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - Merci pour votre confiance</p>
        <p>Cette facture a été générée automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
