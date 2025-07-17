<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header de confirmation -->
            <div class="text-center mb-8">
                <div class="bg-green-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Commande confirmée !</h1>
                <p class="text-gray-600">Merci pour votre achat. Votre commande #{{ $order->id }} a été traitée avec succès.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Détails de la commande -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails de la commande</h2>

                    <!-- Articles commandés -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 last:border-b-0">
                                <!-- Image du produit -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-20 bg-gray-200 rounded-lg overflow-hidden">
                                        @if($item->productVariant && $item->productVariant->product && $item->productVariant->color)
                                            @php
                                                $imageUrl = $item->productVariant->product->getImageUrl($item->productVariant->color->id, 'large');
                                            @endphp
                                            @if($imageUrl)
                                                <img src="{{ $imageUrl }}"
                                                     alt="{{ $item->productVariant->product->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">N/A</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">N/A</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Détails du produit -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        {{ $item->productVariant->product->name ?? 'Produit' }}
                                    </h4>
                                    <p class="text-xs text-gray-600">
                                        Taille: {{ $item->productVariant->size->label ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Couleur: {{ $item->productVariant->color->name ?? 'N/A' }}
                                    </p>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs text-gray-600">Quantité: {{ $item->quantity }}</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ number_format($item->total_price, 2) }}€
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totaux -->
                    <div class="space-y-2 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ number_format($order->subtotal - $order->shipping_price - $order->discount_amount, 2) }}€</span>
                        </div>
                        @if($order->shipping_price > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-medium">{{ number_format($order->shipping_price, 2) }}€</span>
                            </div>
                        @else
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-medium">Gratuit</span>
                            </div>
                        @endif
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Réduction @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                                <span class="font-medium">-{{ number_format($order->discount_amount, 2) }}€</span>
                            </div>
                        @endif
                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Total</span>
                                <span class="text-base font-medium text-gray-900">{{ number_format($order->total_price, 2) }}€</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations de livraison -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations de livraison</h2>

                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Adresse de livraison</h3>
                            <div class="text-sm text-gray-600 mt-1">
                                <p>{{ $order->first_name }} {{ $order->last_name }}</p>
                                <p>{{ $order->email }}</p>
                                <p>{{ $order->street }}</p>
                                @if($order->apartment)
                                    <p>{{ $order->apartment }}</p>
                                @endif
                                <p>{{ $order->postal_code }} {{ $order->city }}</p>
                                <p>{{ $order->country }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Méthode de livraison</h3>
                            <div class="text-sm text-gray-600 mt-1">
                                @if($order->shipping_method === 'ups_standard')
                                    <p>UPS Standard (4-7 jours ouvrables)</p>
                                @elseif($order->shipping_method === 'ups_premium')
                                    <p>UPS Premium (1-3 jours ouvrables)</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Statut de la commande</h3>
                            <div class="text-sm text-gray-600 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center mt-8">
                <a href="{{ route('home') }}"
                   class="bg-black text-white py-3 px-6 rounded-md hover:bg-gray-800 transition duration-200 font-medium inline-block">
                    Continuer mes achats
                </a>
            </div>
        </div>
    </div>
</div>
