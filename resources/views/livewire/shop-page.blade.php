<div>
    {{-- Bannière avec sélecteur de genre --}}
    <section class="bg-black text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 space-y-4 sm:space-y-0">
                <h1 class="text-xl sm:text-2xl font-bold">{{ $gender === 'men' ? 'Hommes' : 'Femmes' }}</h1>

                <!-- Sélecteur de genre -->
                <div class="flex gap-2 sm:gap-4 w-full sm:w-auto">
                    <button wire:click="switchGender('men')"
                            class="flex-1 sm:flex-none px-3 py-2 sm:px-4 sm:py-2 border border-white text-sm {{ $gender === 'men' ? 'bg-white text-black' : 'bg-transparent text-white' }} rounded transition-colors">
                        Homme
                    </button>
                    <button wire:click="switchGender('women')"
                            class="flex-1 sm:flex-none px-3 py-2 sm:px-4 sm:py-2 border border-white text-sm {{ $gender === 'women' ? 'bg-white text-black' : 'bg-transparent text-white' }} rounded transition-colors">
                        Femme
                    </button>
                </div>
            </div>
            <p class="text-sm sm:text-lg max-w-full sm:max-w-2xl">
                @if($gender === 'men')
                    Renouvelez votre style avec les dernières tendances en matière de
                    vêtements pour hommes ou réalisez une garde-robe parfaitement
                    soignée grâce à notre gamme de pièces intemporelles.
                @else
                    Découvrez notre collection féminine élégante et moderne,
                    alliant confort et style pour toutes les occasions.
                @endif
            </p>
        </div>
    </section>

    {{-- Section principale avec filtres et produits --}}
    <section class="py-4 sm:py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-4 lg:gap-8">
                {{-- Sidebar Filtres --}}
                <div class="w-full lg:w-80 lg:flex-shrink-0">
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-4 sm:mb-6">
                            <h2 class="text-lg font-medium text-gray-900">Filtres</h2>
                            <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">Effacer les filtres</button>
                        </div>

                        {{-- Recherche dans la page shop --}}
                        <div class="mb-4 sm:mb-6">
                            <h3 class="font-medium text-gray-900 mb-3">Recherche</h3>
                            <input type="text"
                                   wire:model.live="search"
                                   placeholder="Rechercher un produit..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-black focus:border-transparent">
                        </div>

                        {{-- Catégories --}}
                        <div class="mb-4 sm:mb-6">
                            <h3 class="font-medium text-gray-900 mb-3">Catégories</h3>
                            <div class="space-y-2">
                                @foreach($productTypes as $type)
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox"
                                               wire:model.live="selectedCategories"
                                               value="{{ $type->id }}"
                                               class="mr-3 rounded">
                                        <span class="text-sm text-gray-700">{{ $type->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Couleurs --}}
                        <div class="mb-4 sm:mb-6">
                            <h3 class="font-medium text-gray-900 mb-3">Couleur</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($colors as $color)
                                    <div wire:click="toggleColor({{ $color->id }})"
                                         class="w-8 h-8 rounded-full cursor-pointer border-2 {{ in_array($color->id, $selectedColors) ? 'border-black' : 'border-gray-300' }} relative"
                                         style="background-color: {{ $color->hex_code }};"
                                         title="{{ $color->name }}">
                                        @if(in_array($color->id, $selectedColors))
                                            <div class="absolute inset-0 flex items-center justify-center text-xs {{ $color->hex_code === '#374151' ? 'text-white' : 'text-black' }}">✓</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Dropdown pour le type de filtre couleur (apparaît seulement si 2+ couleurs sélectionnées) --}}
                            @if(count($selectedColors) >= 2)
                                <div class="mt-4 p-3 bg-gray-50 rounded-md border border-gray-200">
                                    <label class="block text-sm text-gray-700 mb-2">
                                        Afficher les produits avec :
                                    </label>
                                    <select wire:model.live="colorFilterType"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:ring-2 focus:ring-black focus:border-transparent">
                                        <option value="ou">Au moins une de ces couleurs (OU)</option>
                                        <option value="et">Toutes ces couleurs (ET)</option>
                                    </select>
                                    <p class="text-xs text-gray-600 mt-1">
                                        @if($colorFilterType === 'ou')
                                            Les produits affichés auront au moins une des couleurs sélectionnées.
                                        @else
                                            Les produits affichés auront toutes les couleurs sélectionnées.
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Contenu principal --}}
                <div class="flex-1">
                    {{-- En-tête avec tri --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                        <div>
                            <p class="text-sm text-gray-600">
                                Affichage de {{ $products->count() }} produits
                                @if(!empty($search))
                                    pour "{{ $search }}"
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center space-x-2 w-full sm:w-auto">
                            <label class="text-sm text-gray-600 whitespace-nowrap">Trier par:</label>
                            <select wire:model.live="sortBy" class="flex-1 sm:flex-none border border-gray-300 rounded-md px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-black focus:border-transparent">
                                <option value="popular">Populaire</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="name">Nom A-Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Grille de produits --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
                        @forelse($products as $product)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                                {{-- Image carrée avec changement dynamique --}}
                                <div class="relative">
                                    <a href="/shop/{{ $gender }}/{{ $product->slug }}" class="block">
                                        @if($product->getDefaultImage('large'))
                                            <img id="product-image-{{ $product->id }}"
                                                 src="{{ $product->getDefaultImage('large') }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-48 sm:h-64 object-cover">
                                        @else
                                            <div id="product-image-{{ $product->id }}"
                                                 class="w-full h-48 sm:h-64 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-sm">Image bientôt disponible</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                {{-- Informations produit --}}
                                <div class="p-3 sm:p-4">
                                    <a href="/shop/{{ $gender }}/{{ $product->slug }}" class="block">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-medium text-gray-900 mb-1 truncate">
                                                    {{ $product->name }}
                                                    @if($product->productType->gender === 'unisex')
                                                        <span class="inline-block text-xs text-green-700 bg-green-100 px-1 py-0.5 rounded ml-1">
                                                            Unisexe
                                                        </span>
                                                    @endif
                                                </h3>
                                                <p class="text-sm text-gray-900 font-medium">{{ number_format($product->price, 2) }}€</p>
                                            </div>
                                            <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded ml-2 whitespace-nowrap">
                                                {{ $product->productType->name }}
                                            </span>
                                        </div>
                                    </a>

                                    {{-- Couleurs disponibles avec changement d'image --}}
                                    @if($product->variants->isNotEmpty())
                                        <div class="mt-2">
                                            <div class="flex gap-1">
                                                @foreach($product->variants->pluck('color')->unique('id') as $color)
                                                    <div class="w-4 h-4 rounded-full border border-gray-300 cursor-pointer"
                                                         style="background-color: {{ $color->hex_code }};"
                                                         title="{{ $color->name }}"
                                                         onmouseover="changeProductImage({{ $product->id }}, {{ $color->id }}, '{{ $product->getImageUrl($color->id, 'large') }}')"
                                                         onmouseout="resetProductImage({{ $product->id }}, '{{ $product->getDefaultImage('large') }}')"></div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 sm:py-16">
                                @if(!empty($search))
                                    <p class="text-gray-600 text-lg mb-4">
                                        Aucun produit trouvé pour "{{ $search }}" dans la section {{ $gender === 'men' ? 'Hommes' : 'Femmes' }}.
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        Essayez de rechercher dans
                                        <a href="{{ route($gender === 'men' ? 'shop.women' : 'shop.men', ['search' => $search]) }}"
                                           class="text-blue-600 underline hover:text-blue-800">
                                            la section {{ $gender === 'men' ? 'Femmes' : 'Hommes' }}
                                        </a>
                                        ou modifiez vos filtres.
                                    </p>
                                @else
                                    <p class="text-gray-600 text-lg mb-4">Aucun produit trouvé.</p>
                                    <p class="text-gray-600 text-sm">
                                        Essayez de modifier vos filtres ou parcourez notre collection complète.
                                    </p>
                                @endif
                            </div>
                        @endforelse
                    </div>

                    {{-- Bouton charger plus --}}
                    @if($hasMoreProducts)
                        <div class="text-center">
                            <button wire:click="loadMore" class="border border-gray-400 text-gray-700 px-6 py-3 text-sm bg-white rounded-md hover:bg-gray-50 transition-colors">
                                Charger plus de produits
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function changeProductImage(productId, colorId, imageUrl) {
        const element = document.getElementById('product-image-' + productId);
        if (element) {
            if (imageUrl && imageUrl !== 'null' && imageUrl !== '') {
                // C'est une vraie image
                if (element.tagName === 'IMG') {
                    element.src = imageUrl;
                } else {
                    // Remplacer le div par une image
                    const img = document.createElement('img');
                    img.id = 'product-image-' + productId;
                    img.src = imageUrl;
                    img.alt = 'Produit';
                    img.style.cssText = 'width: 100%; height: 250px; object-fit: cover; display: block;';
                    element.parentNode.replaceChild(img, element);
                }
            } else {
                // Pas d'image, afficher le placeholder
                if (element.tagName === 'IMG') {
                    // Remplacer l'image par un div
                    const div = document.createElement('div');
                    div.id = 'product-image-' + productId;
                    div.style.cssText = 'width: 100%; height: 250px; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center;';
                    div.innerHTML = '<span style="color: #6b7280; font-size: 0.875rem;">Image bientôt disponible</span>';
                    element.parentNode.replaceChild(div, element);
                }
            }
        }
    }

    function resetProductImage(productId, defaultImageUrl) {
        const element = document.getElementById('product-image-' + productId);
        if (element) {
            if (defaultImageUrl && defaultImageUrl !== 'null' && defaultImageUrl !== '') {
                // Remettre l'image par défaut
                if (element.tagName === 'IMG') {
                    element.src = defaultImageUrl;
                } else {
                    // Remplacer le div par une image
                    const img = document.createElement('img');
                    img.id = 'product-image-' + productId;
                    img.src = defaultImageUrl;
                    img.alt = 'Produit';
                    img.style.cssText = 'width: 100%; height: 250px; object-fit: cover; display: block;';
                    element.parentNode.replaceChild(img, element);
                }
            } else {
                // Remettre le placeholder
                if (element.tagName === 'IMG') {
                    const div = document.createElement('div');
                    div.id = 'product-image-' + productId;
                    div.style.cssText = 'width: 100%; height: 250px; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center;';
                    div.innerHTML = '<span style="color: #6b7280; font-size: 0.875rem;">Image bientôt disponible</span>';
                    element.parentNode.replaceChild(div, element);
                }
            }
        }
    }
</script>
