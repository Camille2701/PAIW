<div class="min-h-screen bg-white">
    {{-- Section Hero comme dans la homepage --}}
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-8">Hommes</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Renouvelez votre style avec les dernières tendances en matière de
                    vêtements pour hommes ou réalisez une garde-robe parfaitement
                    soignée grâce à notre gamme de pièces intemporelles.
                </p>
            </div>
        </div>
    </section>

    {{-- Section principale --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">
                {{-- Sidebar Filtres --}}
                <div class="w-full lg:w-1/4">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-medium text-gray-900">Filtres</h2>
                            <button class="text-sm text-gray-500 hover:text-gray-700">Effacer les filtres</button>
                        </div>

                        {{-- Catégories --}}
                        <div class="mb-8">
                            <h3 class="font-medium text-gray-900 mb-4">Catégories</h3>
                            <div class="space-y-3">
                                @foreach($productTypes as $type)
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox"
                                               wire:model.live="selectedCategories"
                                               value="{{ $type->id }}"
                                               class="rounded border-gray-300 text-black focus:ring-black focus:ring-offset-0">
                                        <span class="ml-3 text-sm text-gray-700">{{ $type->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Couleurs --}}
                        <div class="mb-8">
                            <h3 class="font-medium text-gray-900 mb-4">Couleur</h3>
                            <div class="grid grid-cols-5 gap-3">
                                @foreach($colors as $color)
                                    <label class="cursor-pointer group">
                                        <input type="checkbox"
                                               wire:model.live="selectedColors"
                                               value="{{ $color->id }}"
                                               class="sr-only">
                                        <div class="w-10 h-10 rounded-full border-2 group-hover:scale-110 transition-transform duration-200
                                                    {{ in_array($color->id, $selectedColors) ? 'border-gray-900 ring-2 ring-gray-900 ring-offset-2' : 'border-gray-300' }}"
                                             style="background-color: {{ $color->hex_code ?? '#ccc' }}">
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contenu principal --}}
                <div class="flex-1">
                    {{-- En-tête avec tri --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">
                                Affichage de {{ $products->count() }} produits
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <label class="text-sm text-gray-600">Trier par:</label>
                            <select wire:model.live="sortBy"
                                    class="border border-gray-300 rounded-md px-4 py-2 text-sm bg-white focus:ring-black focus:border-black">
                                <option value="popular">Populaire</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="name">Nom A-Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Grille de produits - Style cohérent avec homepage --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        @forelse($products as $product)
                            <div class="group cursor-pointer">
                                {{-- Image du produit --}}
                                <div class="bg-gray-300 h-80 w-full rounded-lg flex items-center justify-center mb-4 group-hover:shadow-lg transition-shadow duration-300">
                                    <span class="text-gray-600">{{ $product->name }}</span>
                                </div>

                                {{-- Informations du produit --}}
                                <div class="text-center">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">{{ $product->productType->name ?? 'N/A' }}</p>
                                    <p class="font-medium text-gray-900">{{ number_format($product->price, 2) }}€</p>
                                    <div class="text-xs text-gray-500 mt-1">M</div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <p class="text-gray-500 text-lg">Aucun produit trouvé.</p>
                                <p class="text-gray-400 text-sm mt-2">Essayez de modifier vos filtres</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Bouton "Charger plus" comme dans le wireframe --}}
                    @if($hasMoreProducts)
                        <div class="text-center">
                            <button wire:click="loadMore"
                                    class="bg-white border-2 border-black text-black px-8 py-3 text-lg font-medium hover:bg-black hover:text-white transition-colors duration-300">
                                Charger plus de produits
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
