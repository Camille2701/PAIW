<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec étapes -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-8">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                1
                            </div>
                            <span class="ml-2 text-sm font-medium text-blue-600">Adresse</span>
                        </div>

                        <div class="w-16 border-t border-gray-300"></div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                2
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Livraison</span>
                        </div>

                        <div class="w-16 border-t border-gray-300"></div>

                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                                3
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-500">Paiement</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formulaire d'adresse -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="px-6 py-8">
                            <h1 class="text-2xl font-bold text-gray-900 mb-6">Achat</h1>

                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Informations de livraison</h2>

                            <form wire:submit.prevent="proceedToPayment" class="space-y-6">
                                <!-- Prénom et Nom -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="text"
                                               wire:model="first_name"
                                               placeholder="Prénom"
                                               class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror">
                                        @error('first_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <input type="text"
                                               wire:model="last_name"
                                               placeholder="Nom"
                                               class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror">
                                        @error('last_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Adresse -->
                                <div>
                                    <input type="text"
                                           wire:model="street"
                                           placeholder="Adresse"
                                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('street') border-red-500 @enderror">
                                    @error('street')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Appartement (facultatif) -->
                                <div>
                                    <input type="text"
                                           wire:model="apartment"
                                           placeholder="Appartement, suite, etc. (facultatif)"
                                           class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <!-- Ville, Pays, Code postal -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="text"
                                               wire:model="city"
                                               placeholder="Ville"
                                               class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('city') border-red-500 @enderror">
                                        @error('city')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <select wire:model="country"
                                                class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('country') border-red-500 @enderror">
                                            <option value="France">France</option>
                                            <option value="Belgique">Belgique</option>
                                            <option value="Suisse">Suisse</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                        </select>
                                        @error('country')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <input type="text"
                                               wire:model="postal_code"
                                               placeholder="Code Postal"
                                               class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('postal_code') border-red-500 @enderror">
                                        @error('postal_code')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bouton continuer -->
                                <div class="pt-4">
                                    <button type="submit"
                                            class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium">
                                        Passer à la livraison
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Récapitulatif du panier -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="px-6 py-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Votre panier</h3>

                            <!-- Items du panier -->
                            <div class="space-y-4 mb-6">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center space-x-4">
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
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
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
                                                    {{ number_format(($item->productVariant->product->price ?? 0) * $item->quantity, 2) }}€
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Code de coupon -->
                            <div class="mb-6">
                                <div class="flex space-x-2">
                                    <input type="text"
                                           wire:model="coupon_code"
                                           placeholder="Entrez le code de coupon ici"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <button wire:click="applyCoupon"
                                            type="button"
                                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors text-sm">
                                        Appliquer
                                    </button>
                                </div>
                            </div>

                            <!-- Totaux -->
                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Sous-total</span>
                                    <span class="font-medium">{{ number_format($totalPrice, 2) }}€</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Livraison</span>
                                    <span class="text-gray-500">Calculé à l'étape suivante</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span class="text-base font-medium text-gray-900">{{ number_format($totalPrice, 2) }}€</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
</div>
