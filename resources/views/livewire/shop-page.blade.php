<div>
    {{-- Bannière noire sous le header --}}
    <section style="background-color: #000; color: white; padding: 3rem 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
            <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Hommes</h1>
            <p style="font-size: 1.1rem; max-width: 600px;">
                Renouvelez votre style avec les dernières tendances en matière de
                vêtements pour hommes ou réalisez une garde-robe parfaitement
                soignée grâce à notre gamme de pièces intemporelles.
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
                                <div wire:click="toggleColor('orange')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('orange', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #f97316;"></div>
                                <div wire:click="toggleColor('purple')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('purple', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #9333ea;"></div>
                                <div wire:click="toggleColor('blue')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('blue', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #2563eb;"></div>
                                <div wire:click="toggleColor('green')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('green', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #16a34a;"></div>
                                <div wire:click="toggleColor('teal')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('teal', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #0d9488;"></div>
                                <div wire:click="toggleColor('red')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('red', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #dc2626;"></div>
                                <div wire:click="toggleColor('cyan')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('cyan', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #06b6d4;"></div>
                                <div wire:click="toggleColor('black')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('black', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #374151;"></div>
                                <div wire:click="toggleColor('pink')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('pink', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #ec4899;"></div>
                                <div wire:click="toggleColor('lime')" style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid {{ in_array('lime', $selectedColors) ? '#000' : '#d1d5db' }}; background-color: #65a30d;"></div>
                            </div>
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
                            <div style="background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                                {{-- Image carrée --}}
                                <div style="width: 100%; height: 250px; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: #6b7280; font-size: 0.875rem;">Image</span>
                                </div>

                                {{-- Informations produit --}}
                                <div style="padding: 1rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <div style="flex: 1;">
                                            <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.25rem;">{{ $product->name }}</h3>
                                            <p style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ number_format($product->price, 2) }}€</p>
                                        </div>
                                        <span style="font-size: 0.75rem; color: #6b7280; background-color: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-left: 0.5rem;">
                                            M
                                        </span>
                                    </div>
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
