<div class="bg-gray-50 min-h-screen">
    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="lg:grid lg:grid-cols-2">

                <!-- Section images -->
                <div class="p-8">
                    <div class="flex gap-4">
                        <!-- Miniatures à gauche -->
                        <div class="flex flex-col gap-3">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-300 transition-colors">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endfor
                        </div>

                        <!-- Image principale -->
                        <div class="flex-1 aspect-square bg-gray-200 rounded-2xl flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">Photo du produit</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section informations produit -->
                <div class="p-8 lg:p-12 bg-white">

                    <!-- Titre et actions -->
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                        <div class="flex gap-2">
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Prix avec options de paiement -->
                    <div class="mb-6">
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 2) }}€</span>
                            <span class="text-sm text-gray-500">ou 4 paiements sans intérêt de {{ number_format($product->price / 4, 2) }}€</span>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 underline">En savoir plus</a>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-700 leading-relaxed mb-8">
                        {{ $product->description ?? 'Renouvelez votre style avec les dernières tendances en matière de vêtements pour hommes ou réalisez une garde-robe parfaitement soignée grâce à notre gamme de pièces intemporelles.' }}
                    </p>

                    <!-- Couleur -->
                    @if($availableColors && $availableColors->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Couleur</h3>
                        <div class="flex gap-3">
                            @foreach($availableColors as $color)
                            <button wire:click="$set('selectedColorId', {{ $color->id }})"
                                    class="w-12 h-12 rounded-full border-2 transition-all {{ $selectedColorId == $color->id ? 'border-gray-900 ring-2 ring-gray-900 ring-offset-2' : 'border-gray-300 hover:border-gray-400' }}"
                                    style="background-color: {{ $color->hex_code }}"
                                    title="{{ $color->name }}">
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Taille -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Taille</h3>
                            <button class="text-sm text-blue-600 hover:text-blue-700 underline">Guide des tailles</button>
                        </div>

                        <div class="grid grid-cols-7 gap-2 mb-4">
                            @foreach($availableSizes as $size)
                            @php
                                $isAvailable = $this->isSizeAvailable($size->id);
                            @endphp
                            <button wire:click="$set('selectedSizeId', {{ $size->id }})"
                                    {{ $isAvailable ? '' : 'disabled' }}
                                    class="py-3 px-2 text-sm font-medium border rounded text-center transition-all
                                    {{ $selectedSizeId == $size->id && $isAvailable ? 'border-gray-900 bg-gray-900 text-white' : '' }}
                                    {{ $isAvailable && $selectedSizeId != $size->id ? 'border-gray-300 text-gray-900 hover:border-gray-400 bg-white' : '' }}
                                    {{ !$isAvailable ? 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed line-through' : '' }}">
                                {{ $size->label }}
                            </button>
                            @endforeach
                        </div>

                        @if($selectedColorId)
                            <p class="text-xs text-gray-500 mb-4">Les tailles grisées ne sont pas disponibles pour cette couleur</p>
                        @endif

                        <!-- Information modèle -->
                        <p class="text-sm text-gray-600 mb-6">Hauteur du modèle : 189 cm, Taille 41</p>
                    </div>

                    <!-- Quantité et Ajouter au panier -->
                    <div class="space-y-4 mb-8">
                        <!-- Label Quantité -->
                        <h3 class="text-lg font-medium text-gray-900">Quantité</h3>

                        <div class="flex gap-4">
                            <!-- Quantité -->
                            <div class="flex items-center border border-gray-300 rounded">
                                <button wire:click="$set('quantity', {{ max(1, $quantity - 1) }})"
                                        class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">−</button>
                                <span class="px-4 py-3 border-x border-gray-300 min-w-[60px] text-center">{{ $quantity }}</span>
                                <button wire:click="$set('quantity', {{ $quantity + 1 }})"
                                        class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">+</button>
                            </div>

                            <!-- Bouton ajouter au panier -->
                            <button wire:click="addToCart"
                                    {{ !$currentVariant || $currentVariant->stock <= 0 ? 'disabled' : '' }}
                                    class="flex-1 bg-gray-900 text-white py-3 px-6 rounded font-medium hover:bg-gray-800 transition-colors flex items-center justify-center {{ !$currentVariant || $currentVariant->stock <= 0 ? 'opacity-50 cursor-not-allowed bg-gray-400' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13L4.5 18M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                                Ajouter au panier - {{ number_format($product->price * $quantity, 2) }}€
                            </button>
                        </div>
                    </div>

                    <!-- Informations de livraison -->
                    <div class="border-t border-gray-200 pt-6 space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>livraison standard gratuite</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <a href="#" class="text-blue-600 hover:text-blue-700 underline">Retours gratuits</a>
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
