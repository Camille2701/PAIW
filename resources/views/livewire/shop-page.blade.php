<div>
    {{-- Bannière avec sélecteur de genre --}}
    <section style="background-color: #000; color: white; padding: 3rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h1 style="font-size: 2rem; font-weight: bold;">{{ $gender === 'men' ? 'Hommes' : 'Femmes' }}</h1>

                <!-- Sélecteur de genre -->
                <div style="display: flex; gap: 1rem;">
                    <button wire:click="switchGender('men')"
                            style="padding: 0.5rem 1rem; border: 1px solid white; background: {{ $gender === 'men' ? 'white' : 'transparent' }}; color: {{ $gender === 'men' ? 'black' : 'white' }}; border-radius: 0.25rem; cursor: pointer;">
                        Homme
                    </button>
                    <button wire:click="switchGender('women')"
                            style="padding: 0.5rem 1rem; border: 1px solid white; background: {{ $gender === 'women' ? 'white' : 'transparent' }}; color: {{ $gender === 'women' ? 'black' : 'white' }}; border-radius: 0.25rem; cursor: pointer;">
                        Femme
                    </button>
                </div>
            </div>
            <p style="font-size: 1.1rem; max-width: 600px;">
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
    <section style="padding: 2rem 0; background-color: #f9fafb;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: flex; gap: 2rem;">
                {{-- Sidebar Filtres --}}
                <div style="width: 280px; flex-shrink: 0;">
                    <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                            <h2 style="font-size: 1.1rem; font-weight: 500; color: #111827;">Filtres</h2>
                            <button wire:click="clearFilters" style="font-size: 0.875rem; color: #2563eb; cursor: pointer; border: none; background: none;">Effacer les filtres</button>
                        </div>

                        {{-- Recherche dans la page shop --}}
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 500; color: #111827; margin-bottom: 1rem;">Recherche</h3>
                            <input type="text"
                                   wire:model.live="search"
                                   placeholder="Rechercher un produit..."
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem;">
                        </div>

                        {{-- Catégories --}}
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 500; color: #111827; margin-bottom: 1rem;">Catégories</h3>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                @foreach($productTypes as $type)
                                    <label style="display: flex; align-items: center; cursor: pointer;">
                                        <input type="checkbox"
                                               wire:model.live="selectedCategories"
                                               value="{{ $type->id }}"
                                               style="margin-right: 0.75rem;">
                                        <span style="font-size: 0.875rem; color: #374151;">{{ $type->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Couleurs --}}
                        <div style="margin-bottom: 1.5rem;">
                            <h3 style="font-weight: 500; color: #111827; margin-bottom: 1rem;">Couleur</h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @foreach($colors as $color)
                                    <div wire:click="toggleColor({{ $color->id }})"
                                         style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array($color->id, $selectedColors) ? '#000' : '#d1d5db' }}; background-color: {{ $color->hex_code }}; position: relative;"
                                         title="{{ $color->name }}">
                                        @if(in_array($color->id, $selectedColors))
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: {{ $color->hex_code === '#374151' ? 'white' : 'black' }}; font-size: 12px;">✓</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Dropdown pour le type de filtre couleur (apparaît seulement si 2+ couleurs sélectionnées) --}}
                            @if(count($selectedColors) >= 2)
                                <div style="margin-top: 1rem; padding: 0.75rem; background-color: #f3f4f6; border-radius: 0.375rem; border: 1px solid #d1d5db;">
                                    <label style="font-size: 0.875rem; color: #374151; display: block; margin-bottom: 0.5rem;">
                                        Afficher les produits avec :
                                    </label>
                                    <select wire:model.live="colorFilterType"
                                            style="width: 100%; padding: 0.375rem; border: 1px solid #d1d5db; border-radius: 0.25rem; font-size: 0.875rem; background-color: white;">
                                        <option value="ou">Au moins une de ces couleurs (OU)</option>
                                        <option value="et">Toutes ces couleurs (ET)</option>
                                    </select>
                                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
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
                <div style="flex: 1;">
                    {{-- En-tête avec tri --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280;">
                                Affichage de {{ $products->count() }} produits
                                @if(!empty($search))
                                    pour "{{ $search }}"
                                @endif
                            </p>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <label style="font-size: 0.875rem; color: #6b7280;">Trier par:</label>
                            <select wire:model.live="sortBy" style="border: 1px solid #d1d5db; border-radius: 0.25rem; padding: 0.25rem 0.75rem; font-size: 0.875rem; background: white;">
                                <option value="popular">Populaire</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="name">Nom A-Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Grille de produits --}}
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
                        @forelse($products as $product)
                            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.2s ease;"
                                 onmouseover="this.style.transform='translateY(-2px)'"
                                 onmouseout="this.style.transform='translateY(0)'">
                                {{-- Image carrée avec changement dynamique --}}
                                <div style="position: relative;">
                                    <a href="/shop/{{ $gender }}/{{ $product->slug }}" style="text-decoration: none;">
                                        @if($product->getDefaultImage('large'))
                                            <img id="product-image-{{ $product->id }}"
                                                 src="{{ $product->getDefaultImage('large') }}"
                                                 alt="{{ $product->name }}"
                                                 style="width: 100%; height: 250px; object-fit: cover; display: block;">
                                        @else
                                            <div id="product-image-{{ $product->id }}"
                                                 style="width: 100%; height: 250px; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                                <span style="color: #6b7280; font-size: 0.875rem;">Image bientôt disponible</span>
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                {{-- Informations produit --}}
                                <div style="padding: 1rem;">
                                    <a href="/shop/{{ $gender }}/{{ $product->slug }}" style="text-decoration: none; color: inherit;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                            <div style="flex: 1;">
                                                <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.25rem;">{{ $product->name }}</h3>
                                                <p style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ number_format($product->price, 2) }}€</p>
                                            </div>
                                            <span style="font-size: 0.75rem; color: #6b7280; background-color: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-left: 0.5rem;">
                                                {{ $product->productType->name }}
                                            </span>
                                        </div>
                                    </a>

                                    {{-- Couleurs disponibles avec changement d'image --}}
                                    @if($product->variants->isNotEmpty())
                                        <div style="margin-top: 0.5rem;">
                                            <div style="display: flex; gap: 0.25rem;">
                                                @foreach($product->variants->pluck('color')->unique('id') as $color)
                                                    <div style="width: 16px; height: 16px; border-radius: 50%; background-color: {{ $color->hex_code }}; border: 1px solid #d1d5db; cursor: pointer;"
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
                            <div style="grid-column: span 3; text-align: center; padding: 4rem 0;">
                                <p style="color: #6b7280; font-size: 1.1rem;">Aucun produit trouvé.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Bouton charger plus --}}
                    @if($hasMoreProducts)
                        <div style="text-align: center;">
                            <button wire:click="loadMore" style="border: 1px solid #9ca3af; color: #374151; padding: 0.75rem 2rem; font-size: 0.875rem; background: white; border-radius: 0.25rem; cursor: pointer;">
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
