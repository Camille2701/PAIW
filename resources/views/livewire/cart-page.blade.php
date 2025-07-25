<div>
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
                                    <div class="flex items-start space-x-4 py-6 border-b border-gray-200">
                                        <!-- Image du produit -->
                                        <div class="flex-shrink-0">
                                            <div class="w-24 h-32 bg-gray-200 rounded-lg overflow-hidden">
                                                @if($item->productVariant && $item->productVariant->product && $item->productVariant->color)
                                                    @php
                                                        // Obtenir l'image pour la couleur spécifique du variant
                                                        $imageUrl = $item->productVariant->product->getImageUrl($item->productVariant->color->id, 'large');
                                                    @endphp
                                                    @if($imageUrl)
                                                        <img src="{{ $imageUrl }}"
                                                             alt="{{ $item->productVariant->product->name }} - {{ $item->productVariant->color->name }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-gray-500 text-xs">Image bientôt disponible</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">Image bientôt disponible</span>
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
                                            </p>                            <!-- Contrôles de quantité -->
                            <div class="flex items-center mt-4 space-x-3">
                                <label class="text-sm text-gray-600">Quantité:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white shadow-sm">
                                    <button wire:click="decreaseQuantity({{ $item->product_variant_id }})"
                                            type="button"
                                            class="px-3 py-2 text-gray-600 hover:text-white hover:bg-red-500 transition-all duration-200 cursor-pointer font-medium select-none"
                                            title="{{ $item->quantity <= 1 ? 'Supprimer du panier' : 'Diminuer la quantité' }}">
                                        -
                                    </button>
                                    <span class="px-4 py-2 border-l border-r border-gray-300 bg-gray-50 font-medium text-gray-900 min-w-[3rem] text-center">
                                        {{ $item->quantity }}
                                    </span>
                                    <button wire:click="increaseQuantity({{ $item->product_variant_id }})"
                                            type="button"
                                            class="px-3 py-2 text-gray-600 font-medium select-none transition-all duration-200 {{ $item->quantity >= ($item->productVariant->stock ?? 0) ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:text-white hover:bg-green-500 cursor-pointer' }}"
                                            {{ $item->quantity >= ($item->productVariant->stock ?? 0) ? 'disabled' : '' }}
                                            title="{{ $item->quantity >= ($item->productVariant->stock ?? 0) ? 'Stock maximum atteint' : 'Augmenter la quantité' }}">
                                        +
                                    </button>
                                </div>
                                @if($item->productVariant && $item->productVariant->stock)
                                    <span class="text-xs text-gray-500 font-medium">
                                        ({{ $item->productVariant->stock }} en stock)
                                    </span>
                                @endif
                            </div>

                                            <!-- Prix -->
                                            <div class="flex items-center justify-between mt-4">
                                                <span class="text-lg font-semibold text-gray-900">
                                                    {{ number_format(($item->productVariant->product->price ?? 0) * $item->quantity, 2) }}€
                                                </span>
                                                <button wire:click="confirmDeleteItem({{ $item->product_variant_id }})"
                                                        type="button"
                                                        class="text-red-600 hover:text-red-800 text-sm cursor-pointer">
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
                                        <h3 class="text-sm font-medium text-gray-900 mb-3">Code de réduction</h3>
                                        @if(!$coupon_applied)
                                            <div class="flex space-x-2">
                                                <input type="text"
                                                       wire:model="coupon_code"
                                                       placeholder="Entrez votre code"
                                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                <button wire:click="applyCoupon"
                                                        type="button"
                                                        class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium cursor-pointer">
                                                    Appliquer
                                                </button>
                                            </div>
                                            @if($coupon_message)
                                                <p class="text-sm mt-2 {{ $coupon_applied ? 'text-green-600' : 'text-red-600' }}">{{ $coupon_message }}</p>
                                            @endif
                                        @else
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="text-sm font-medium text-green-800">Coupon {{ strtoupper($coupon_code) }} appliqué</span>
                                                    </div>
                                                    <button wire:click="removeCoupon"
                                                            type="button"
                                                            class="text-green-600 hover:text-green-800 text-sm underline cursor-pointer">
                                                        Retirer
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Totaux -->
                                    <div class="space-y-3 mb-6">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Sous-total</span>
                                            <span class="font-medium">{{ number_format($totalPrice, 2) }}€</span>
                                        </div>
                                        @if($coupon_applied && $this->getDiscountAmount() > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Réduction ({{ ($coupon_discount * 100) }}%)</span>
                                            <span class="font-medium text-green-600">-{{ number_format($this->getDiscountAmount(), 2) }}€</span>
                                        </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Livraison</span>
                                            <span class="text-gray-500">Calculé à l'étape suivante</span>
                                        </div>
                                        <div class="border-t border-gray-200 pt-3">
                                            <div class="flex justify-between">
                                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                                @if($coupon_applied && $this->getDiscountAmount() > 0)
                                                    <div class="text-right">
                                                        <span class="text-sm text-gray-500 line-through">{{ number_format($totalPrice, 2) }}€</span>
                                                        <span class="text-lg font-semibold text-gray-900 block">{{ number_format($this->getFinalTotal(), 2) }}€</span>
                                                    </div>
                                                @else
                                                    <span class="text-lg font-semibold text-gray-900">{{ number_format($totalPrice, 2) }}€</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de commande -->
                                    <a href="{{ route('checkout') }}"
                                       class="block w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium text-center">
                                        Passer à l'achat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Messages flash -->
    @if (session()->has('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    <!-- Modal de confirmation de suppression -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
             wire:click="cancelDelete">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
                 wire:click.stop>
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">
                        Supprimer l'article
                    </h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Êtes-vous sûr de vouloir supprimer
                            <span class="font-semibold text-gray-700">{{ $itemToDeleteName }}</span>
                            de votre panier ?
                        </p>
                    </div>
                    <div class="flex items-center justify-center px-4 py-3 space-x-3">
                        <button wire:click="cancelDelete"
                                type="button"
                                class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Annuler
                        </button>
                        <button wire:click="removeItem"
                                type="button"
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
