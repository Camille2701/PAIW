<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header avec étapes -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-center space-x-8">
                        <!-- Étape 1: Adresse -->
                        <div class="flex items-center cursor-pointer" wire:click="goToStep(1)">
                            <div class="w-8 h-8 {{ $currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full flex items-center justify-center text-sm font-medium">
                                @if($currentStep > 1)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    1
                                @endif
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-500' }}">Adresse</span>
                        </div>

                        <div class="w-16 border-t {{ $currentStep > 1 ? 'border-blue-600' : 'border-gray-300' }}"></div>

                        <!-- Étape 2: Livraison -->
                        <div class="flex items-center cursor-pointer" wire:click="goToStep(2)">
                            <div class="w-8 h-8 {{ $currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full flex items-center justify-center text-sm font-medium">
                                @if($currentStep > 2)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    2
                                @endif
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-500' }}">Livraison</span>
                        </div>

                        <div class="w-16 border-t {{ $currentStep > 2 ? 'border-blue-600' : 'border-gray-300' }}"></div>

                        <!-- Étape 3: Paiement -->
                        <div class="flex items-center cursor-pointer" wire:click="goToStep(3)">
                            <div class="w-8 h-8 {{ $currentStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full flex items-center justify-center text-sm font-medium">
                                3
                            </div>
                            <span class="ml-2 text-sm font-medium {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-500' }}">Paiement</span>
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

                            @if($currentStep == 1)
                                <h2 class="text-lg font-semibold text-gray-900 mb-6">Informations de livraison</h2>
                            @elseif($currentStep == 2)
                                <h2 class="text-lg font-semibold text-gray-900 mb-6">Méthode de livraison</h2>
                            @elseif($currentStep == 3)
                                <h2 class="text-lg font-semibold text-gray-900 mb-6">Paiement</h2>
                            @endif

                            @if($currentStep == 1)
                                <!-- Étape 1: Informations d'adresse -->
                                <form wire:submit.prevent="proceedToShipping" class="space-y-6">
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

                                <!-- Email (seulement si non connecté) -->
                                @if(!Auth::check())
                                    <div>
                                        <input type="email"
                                               wire:model="email"
                                               placeholder="Adresse email"
                                               class="w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

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
                                            <option value="">Sélectionner une option</option>
                                            <option value="France">France</option>
                                            <option value="Suisse">Suisse</option>
                                            <option value="Belgique">Belgique</option>
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
                                            class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium cursor-pointer">
                                        Passer à la livraison
                                    </button>
                                </div>
                            </form>

                            @elseif($currentStep == 2)
                                <!-- Étape 2: Options de livraison -->
                                <form wire:submit.prevent="proceedToPayment" class="space-y-6">
                                    <!-- Options de livraison -->
                                    <div class="space-y-4">
                                        <!-- UPS Standard (Gratuit) -->
                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 {{ $shipping_method == 'ups_standard' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                            <input type="radio"
                                                   wire:model="shipping_method"
                                                   value="ups_standard"
                                                   wire:change="updateShippingMethod"
                                                   class="sr-only">
                                            <div class="flex items-center justify-between w-full">
                                                <div class="flex items-center">
                                                    <div class="w-4 h-4 border-2 rounded-full mr-3 flex items-center justify-center {{ $shipping_method == 'ups_standard' ? 'border-blue-500' : 'border-gray-300' }}">
                                                        @if($shipping_method == 'ups_standard')
                                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-900">UPS</div>
                                                        <div class="text-sm text-gray-600">4-7 jours ouvrables</div>
                                                    </div>
                                                </div>
                                                <div class="text-lg font-semibold text-gray-900">Gratuit</div>
                                            </div>
                                        </label>

                                        <!-- UPS Premium -->
                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 {{ $shipping_method == 'ups_premium' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                            <input type="radio"
                                                   wire:model="shipping_method"
                                                   value="ups_premium"
                                                   wire:change="updateShippingMethod"
                                                   class="sr-only">
                                            <div class="flex items-center justify-between w-full">
                                                <div class="flex items-center">
                                                    <div class="w-4 h-4 border-2 rounded-full mr-3 flex items-center justify-center {{ $shipping_method == 'ups_premium' ? 'border-blue-500' : 'border-gray-300' }}">
                                                        @if($shipping_method == 'ups_premium')
                                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-900">UPS Premium</div>
                                                        <div class="text-sm text-gray-600">1-3 jours ouvrables</div>
                                                    </div>
                                                </div>
                                                <div class="text-lg font-semibold text-gray-900">4,99€</div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Bouton continuer -->
                                    <div class="pt-4">
                                        <button type="submit"
                                                class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium cursor-pointer">
                                            Passer au paiement
                                        </button>
                                    </div>
                                </form>

                            @elseif($currentStep == 3)
                                <!-- Étape 3: Paiement -->
                                <div wire:loading.class="opacity-50" wire:target="processPayment">
                                    <!-- Section d'informations -->
                                    <div class="mb-6">
                                        <p class="text-sm text-gray-600">Tous les champs sont à titre informatif uniquement</p>
                                    </div>

                                    <!-- Informations de paiement -->
                                    <form wire:submit.prevent="processPayment" class="space-y-6">
                                        <!-- Nom du titulaire -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du titulaire</label>
                                            <input type="text"
                                                   wire:model="card_holder_name"
                                                   placeholder="Jean Dupont"
                                                   disabled
                                                   class="w-full px-3 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                                        </div>

                                        <!-- Numéro de carte -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de la carte</label>
                                            <input type="text"
                                                   wire:model="card_number"
                                                   placeholder="1234 5678 9012 3456"
                                                   disabled
                                                   class="w-full px-3 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                                        </div>

                                        <!-- Expiration et CVC -->
                                        <div class="grid grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Mois</label>
                                                <select wire:model="card_expiry_month" disabled class="w-full px-3 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                                                    <option value="">Mois</option>
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                                                <select wire:model="card_expiry_year" disabled class="w-full px-3 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                                                    <option value="">Année</option>
                                                    @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">CVC</label>
                                                <input type="text"
                                                       wire:model="card_cvc"
                                                       placeholder="123"
                                                       disabled
                                                       class="w-full px-3 py-3 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed">
                                            </div>
                                        </div>

                                        <!-- Bouton payer -->
                                        <div class="pt-4">
                                            <button type="submit"
                                                    :disabled="$wire.processing_payment"
                                                    class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 transition duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2 cursor-pointer">
                                                <span wire:loading.remove wire:target="processPayment">Payer par carte</span>
                                                <span wire:loading wire:target="processPayment" class="flex items-center space-x-2">
                                                    <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                                        <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span>Traitement en cours...</span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
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
                                @if($cartItems)
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
                                @else
                                    <div class="text-center text-gray-500 py-4">
                                        <p>Votre panier est vide</p>
                                    </div>
                                @endif
                            </div>                            <!-- Code de coupon -->
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
                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Sous-total</span>
                                    <span class="font-medium">{{ number_format($totalPrice, 2) }}€</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Livraison</span>
                                    @if($currentStep >= 2)
                                        @if($shipping_price > 0)
                                            <span class="font-medium">{{ number_format($shipping_price, 2) }}€</span>
                                        @else
                                            <span class="font-medium">Gratuit</span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Calculé à l'étape suivante</span>
                                    @endif
                                </div>
                                @if($coupon_applied && $this->getDiscountAmount() > 0)
                                    <div class="flex justify-between text-sm text-green-600">
                                        <span>Réduction (PAIW10 -10%)</span>
                                        <span class="font-medium">-{{ number_format($this->getDiscountAmount(), 2) }}€</span>
                                    </div>
                                @endif
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        @if($currentStep >= 2)
                                            <span class="text-base font-medium text-gray-900">{{ number_format($this->getTotalWithShipping(), 2) }}€</span>
                                        @else
                                            @if($coupon_applied && $this->getDiscountAmount() > 0)
                                                <span class="text-base font-medium text-gray-900">{{ number_format($totalPrice - ($totalPrice * $coupon_discount), 2) }}€</span>
                                            @else
                                                <span class="text-base font-medium text-gray-900">{{ number_format($totalPrice, 2) }}€</span>
                                            @endif
                                        @endif
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
