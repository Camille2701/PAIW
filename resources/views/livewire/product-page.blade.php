<div class="bg-gray-50 min-h-screen">
    <!-- Fil d'Ariane -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="/" class="hover:text-gray-900 transition-colors">Accueil</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                @php
                    $gender = $product->productType->gender === 'unisex' ? 'men' : $product->productType->gender;
                    $genderLabel = match($product->productType->gender) {
                        'men' => 'Hommes',
                        'women' => 'Femmes',
                        'unisex' => 'Unisexe'
                    };
                @endphp
                <a href="/shop/{{ $gender }}" class="hover:text-gray-900 transition-colors capitalize">
                    {{ $genderLabel }}
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="lg:grid lg:grid-cols-2">

                <!-- Section images -->
                <div class="p-8">
                    <!-- Image principale uniquement -->
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100">
                        @if($this->currentImageUrl)
                            <img src="{{ $this->currentImageUrl }}"
                                 alt="{{ $product->name }}{{ $selectedColorId ? ' - ' . $availableColors->firstWhere('id', $selectedColorId)?->name : '' }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">Image bientôt disponible</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Section informations produit -->
                <div class="p-8 lg:p-12 bg-white">

                    <!-- Titre -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    </div>

                    <!-- Indicateur de stock pour la couleur sélectionnée -->
                    @if($selectedColorId)
                        @if($this->isColorInStock())
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-green-700 font-medium">En stock pour cette couleur</span>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-red-700 font-medium">Rupture de stock pour cette couleur</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Indicateur de stock général si aucune couleur sélectionnée -->
                        @php
                            $totalStock = $this->product->variants->sum('stock');
                        @endphp
                        @if($totalStock > 0)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-green-700 font-medium">En stock</span>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-red-700 font-medium">Rupture de stock</span>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Prix -->
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 2) }}€</span>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-700 leading-relaxed mb-8">
                        {{ $product->description ?? 'Renouvelez votre style avec les dernières tendances en matière de vêtements pour hommes ou réalisez une garde-robe parfaitement soignée grâce à notre gamme de pièces intemporelles.' }}
                    </p>

                    <!-- Couleur -->
                    @if($availableColors && $availableColors->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">
                            Couleur
                            @if($selectedColorId)
                                @php $selectedColor = $availableColors->firstWhere('id', $selectedColorId); @endphp
                                @if($selectedColor)
                                    <span class="text-sm font-normal text-gray-600 ml-2">- {{ $selectedColor->name }}</span>
                                @endif
                            @endif
                        </h3>
                        <div class="flex gap-3">
                            @foreach($availableColors as $color)
                            <button wire:click="$set('selectedColorId', {{ $color->id }})"
                                    class="w-12 h-12 rounded-full transition-all cursor-pointer border-2 border-gray-300 hover:border-gray-400 relative {{ $selectedColorId == $color->id ? 'ring-2 ring-gray-900 ring-offset-2' : '' }}"
                                    style="background-color: {{ $color->hex_code }}"
                                    title="{{ $color->name }}">
                                @if($selectedColorId == $color->id)
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif                    <!-- Taille -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Taille</h3>

                        @if(!$selectedColorId)
                            <p class="text-sm text-gray-500 mb-4">Veuillez d'abord sélectionner une couleur pour voir les tailles disponibles</p>
                            <div class="flex flex-wrap gap-2 mb-4 opacity-50">
                                @foreach($availableSizes as $size)
                                <div class="py-2 px-3 text-sm font-medium border border-gray-200 bg-gray-100 text-gray-400 rounded cursor-not-allowed">
                                    {{ $size->label }}
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($availableSizes as $size)
                                @php
                                    $isAvailable = $this->isSizeAvailable($size->id);
                                @endphp
                                <button wire:click="$set('selectedSizeId', {{ $size->id }})"
                                        {{ $isAvailable ? '' : 'disabled' }}
                                        class="py-2 px-3 text-sm font-medium border rounded transition-all relative {{ $isAvailable ? 'cursor-pointer' : 'cursor-not-allowed' }}
                                        {{ $selectedSizeId == $size->id && $isAvailable ? 'border-gray-900 bg-gray-900 text-white' : '' }}
                                        {{ $isAvailable && $selectedSizeId != $size->id ? 'border-gray-300 text-gray-900 hover:border-gray-400 bg-white' : '' }}
                                        {{ !$isAvailable ? 'border-gray-200 bg-gray-100 text-gray-400 opacity-50' : '' }}">
                                    {{ $size->label }}
                                    @if(!$isAvailable)
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-6 h-0.5 bg-gray-400 transform rotate-45"></div>
                                        </div>
                                    @endif
                                </button>
                                @endforeach
                            </div>

                            @if($selectedColorId && !$selectedSizeId)
                                <p class="text-xs text-gray-500 mb-4">Sélectionnez une taille</p>
                            @endif
                        @endif
                    </div>

                    <!-- Quantité et Ajouter au panier -->
                    <div class="space-y-4 mb-8">
                        <!-- Label Quantité -->
                        <h3 class="text-lg font-medium text-gray-900">Quantité</h3>

                        <div class="flex gap-4">
                            <!-- Quantité -->
                            <div class="flex items-center border border-gray-300 rounded">
                                <button wire:click="$set('quantity', {{ max(1, $quantity - 1) }})"
                                        class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">−</button>
                                <span class="px-4 py-3 border-x border-gray-300 min-w-[60px] text-center">{{ $quantity }}</span>
                                <button wire:click="$set('quantity', {{ min($this->getRemainingStock(), $quantity + 1) }})"
                                        class="px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">+</button>
                            </div>

                            <!-- Bouton ajouter au panier -->
                            <button wire:click="addToCart"
                                    {{ !$selectedSizeId || !$this->isInStock() ? 'disabled' : '' }}
                                    class="flex-1 py-3 px-6 rounded font-medium transition-colors flex items-center justify-center cursor-pointer
                                    {{ !$selectedSizeId ? 'bg-gray-400 text-white cursor-not-allowed opacity-50' : '' }}
                                    {{ $selectedSizeId && !$this->isInStock() ? 'bg-red-500 text-white cursor-not-allowed' : '' }}
                                    {{ $selectedSizeId && $this->isInStock() ? 'bg-gray-900 text-white hover:bg-gray-800' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(!$selectedSizeId)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13L4.5 18M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                    @elseif(!$this->isInStock())
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13L4.5 18M7 13h10M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                    @endif
                                </svg>
                                @if(!$selectedSizeId)
                                    Sélectionnez une taille
                                @elseif(!$this->isInStock())
                                    Rupture de stock
                                @else
                                    Ajouter au panier - {{ number_format($product->price * $quantity, 2) }}€
                                @endif
                            </button>
                        </div>

                        <!-- Affichage du stock restant -->
                        @if($selectedSizeId && $this->isInStock())
                            <div class="text-sm text-gray-600">
                                @if($this->getRemainingStock() <= 5)
                                    <span class="text-orange-600 font-medium">
                                        Plus que {{ $this->getRemainingStock() }} en stock
                                    </span>
                                @else
                                    <span class="text-green-600">
                                        {{ $this->getRemainingStock() }} en stock
                                    </span>
                                @endif
                            </div>
                        @endif
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
