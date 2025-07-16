@extends('layouts.app')

@section('title', 'Votre panier')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-8">
                <h1 class="text-2xl font-semibold text-gray-900 mb-2">Votre panier</h1>

                @if($cartItems->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-600 mb-4">Vous n'êtes pas prêt à passer la commande ?</p>
                        <a href="{{ route('shop') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Retournez à la boutique
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Liste des produits -->
                        <div class="lg:col-span-2">
                            <p class="text-gray-600 mb-6">Vous n'êtes pas prêt à passer la commande ?<br>
                            <a href="{{ route('shop') }}" class="text-gray-900 hover:underline">Retournez à la boutique</a></p>

                            <div class="space-y-6">
                                @foreach($cartItems as $item)
                                <div class="flex items-start space-x-4 py-6 border-b border-gray-200" data-variant-id="{{ $item->product_variant_id }}">
                                    <!-- Image du produit -->
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-32 bg-gray-200 rounded-lg overflow-hidden">
                                            @if($item->productVariant && $item->productVariant->product)
                                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">Image</span>
                                                </div>
                                            @else
                                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">Pas d'image</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Détails du produit -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $item->productVariant->product->name ?? 'Produit' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Taille: {{ $item->productVariant->size->label ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Couleur: {{ $item->productVariant->color->name ?? 'N/A' }}
                                        </p>

                                        <!-- Contrôles de quantité -->
                                        <div class="flex items-center mt-4 space-x-3">
                                            <label class="text-sm text-gray-600">Quantité:</label>
                                            <div class="flex items-center border border-gray-300 rounded">
                                                <button type="button"
                                                        class="px-3 py-1 text-gray-600 hover:text-gray-800 decrease-quantity"
                                                        data-variant-id="{{ $item->product_variant_id }}">
                                                    -
                                                </button>
                                                <span class="px-4 py-1 border-l border-r border-gray-300 quantity-display">
                                                    {{ $item->quantity }}
                                                </span>
                                                <button type="button"
                                                        class="px-3 py-1 text-gray-600 hover:text-gray-800 increase-quantity"
                                                        data-variant-id="{{ $item->product_variant_id }}">
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Prix -->
                                        <div class="flex items-center justify-between mt-4">
                                            <span class="text-lg font-semibold text-gray-900">
                                                {{ number_format($item->productVariant->product->price ?? 0, 2) }}€
                                            </span>
                                            <button type="button"
                                                    class="text-red-600 hover:text-red-800 text-sm remove-item"
                                                    data-variant-id="{{ $item->product_variant_id }}">
                                                Supprimer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Récapitulatif de commande -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Récapitulatif de commande</h2>

                                <!-- Code de coupon -->
                                <div class="mb-6">
                                    <input type="text"
                                           placeholder="Entrez le code de coupon ici"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <!-- Totaux -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Sous-total</span>
                                        <span class="font-medium" id="cart-subtotal">{{ number_format($totalPrice, 2) }}€</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Livraison</span>
                                        <span class="text-gray-500">Calculé à l'étape suivante</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3">
                                        <div class="flex justify-between">
                                            <span class="text-lg font-semibold text-gray-900">Total</span>
                                            <span class="text-lg font-semibold text-gray-900" id="cart-total">{{ number_format($totalPrice, 2) }}€</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bouton de commande -->
                                <button class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium">
                                    Continue to checkout
                                </button>
                            </div>

                            <!-- Informations de commande -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de commande</h3>

                                <div class="space-y-4">
                                    <details class="group">
                                        <summary class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-gray-900">
                                            <span>Politique de retour</span>
                                            <span class="group-open:rotate-180 transition-transform">−</span>
                                        </summary>
                                        <div class="mt-2 text-sm text-gray-600">
                                            Ceci est notre exemple de politique de retour qui est tout ce que vous
                                            devez savoir sur nos retours.
                                        </div>
                                    </details>

                                    <details class="group">
                                        <summary class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-gray-900">
                                            <span>Options d'expédition</span>
                                            <span class="group-open:rotate-180 transition-transform">+</span>
                                        </summary>
                                        <div class="mt-2 text-sm text-gray-600">
                                            Informations sur les options d'expédition disponibles.
                                        </div>
                                    </details>

                                    <details class="group">
                                        <summary class="flex justify-between items-center cursor-pointer text-gray-700 hover:text-gray-900">
                                            <span>Options d'expédition</span>
                                            <span class="group-open:rotate-180 transition-transform">+</span>
                                        </summary>
                                        <div class="mt-2 text-sm text-gray-600">
                                            Autres informations sur l'expédition.
                                        </div>
                                    </details>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour mettre à jour l'affichage du panier
    function updateCartDisplay(cartCount, cartTotal) {
        // Mettre à jour le compteur dans le header
        const cartCounter = document.querySelector('.cart-counter');
        if (cartCounter) {
            cartCounter.textContent = cartCount;
        }

        // Mettre à jour les totaux
        const subtotalElement = document.getElementById('cart-subtotal');
        const totalElement = document.getElementById('cart-total');

        if (subtotalElement && totalElement) {
            subtotalElement.textContent = cartTotal.toFixed(2) + '€';
            totalElement.textContent = cartTotal.toFixed(2) + '€';
        }
    }

    // Augmenter la quantité
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const variantId = this.dataset.variantId;
            const quantityDisplay = this.parentNode.querySelector('.quantity-display');
            const currentQuantity = parseInt(quantityDisplay.textContent);

            updateQuantity(variantId, currentQuantity + 1);
        });
    });

    // Diminuer la quantité
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const variantId = this.dataset.variantId;
            const quantityDisplay = this.parentNode.querySelector('.quantity-display');
            const currentQuantity = parseInt(quantityDisplay.textContent);

            if (currentQuantity > 1) {
                updateQuantity(variantId, currentQuantity - 1);
            }
        });
    });

    // Supprimer un article
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const variantId = this.dataset.variantId;
            removeFromCart(variantId);
        });
    });

    // Fonction pour mettre à jour la quantité
    function updateQuantity(variantId, quantity) {
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_variant_id: variantId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage local
                const item = document.querySelector(`[data-variant-id="${variantId}"]`);
                const quantityDisplay = item.querySelector('.quantity-display');
                quantityDisplay.textContent = quantity;

                updateCartDisplay(data.cart_count, data.cart_total);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Fonction pour supprimer un article
    function removeFromCart(variantId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_variant_id: variantId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément du DOM
                    const item = document.querySelector(`[data-variant-id="${variantId}"]`);
                    item.remove();

                    updateCartDisplay(data.cart_count, data.cart_total);

                    // Vérifier s'il n'y a plus d'articles
                    if (data.cart_count === 0) {
                        location.reload();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
});
</script>
@endpush
@endsection
