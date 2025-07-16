<div>
    <!-- Section Hero 1 -->
    <section class="relative bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-8">
                    De meilleurs vêtements pour la planète
                </h1>
                <a href="{{ route('shop') }}" class="bg-white border-2 border-black text-black px-8 py-3 text-lg font-medium hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer inline-block">
                    Acheter
                </a>
            </div>

            <!-- Image principale hero -->
            <div class="mt-12">
                <div class="bg-gray-300 h-96 w-full rounded-lg flex items-center justify-center">
                    <span class="text-gray-600 text-lg">Image Hero Principale</span>
                </div>
            </div>

            <!-- Logos de presse -->
            <div class="mt-12 flex justify-center items-center space-x-8 opacity-60">
                <div class="text-lg font-serif">The New York Times</div>
                <div class="text-lg font-bold">VOGUE</div>
                <div class="text-lg font-bold">VANITY FAIR</div>
                <div class="text-lg font-bold">CNBC</div>
            </div>
        </div>
    </section>

    <!-- Section Hero 2 - Nos derniers arrivages -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-8">
                    Nos derniers arrivages
                </h2>
                <a href="{{ route('shop') }}" class="bg-white border-2 border-black text-black px-8 py-3 text-lg font-medium hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer inline-block">
                    Acheter
                </a>
            </div>

            <!-- Grille de produits -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                @foreach($newArrivals as $product)
                    @if(isset($product->id))
                        <a href="{{ route('product.' . $product->productType->gender, $product->slug) }}" class="group cursor-pointer block">
                    @else
                        <div class="group cursor-pointer">
                    @endif
                        <div class="h-80 w-full rounded-lg mb-4 group-hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            @if(isset($product->id) && $product->getDefaultImage('large'))
                                <img src="{{ $product->getDefaultImage('large') }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="bg-gray-300 h-full w-full flex items-center justify-center">
                                    <span class="text-gray-600">Image bientôt disponible</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="text-gray-600">{{ number_format($product->price, 2) }}€</p>
                    @if(isset($product->id))
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section promotionnelle -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Mode durable et éthique
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Découvrez notre collection de vêtements vintage soigneusement sélectionnés pour leur qualité et leur style intemporel. Chaque pièce raconte une histoire unique.
                    </p>
                    <a href="/about" class="bg-black text-white px-8 py-3 text-lg font-medium hover:bg-gray-800 transition-colors duration-300 cursor-pointer inline-block">
                        Découvrir notre histoire
                    </a>
                </div>
                <div class="bg-gray-300 h-96 w-full rounded-lg flex items-center justify-center">
                    <span class="text-gray-600 text-lg">Image Promotionnelle</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section produits vedettes -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">
                    Nos coups de cœur
                </h2>
                <p class="text-lg text-gray-600">
                    Une sélection de nos pièces les plus appréciées
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredProducts as $product)
                    @if(isset($product->id))
                        <a href="{{ route('product.' . $product->productType->gender, $product->slug) }}" class="group cursor-pointer block">
                    @else
                        <div class="group cursor-pointer">
                    @endif
                        <div class="h-80 w-full rounded-lg mb-4 group-hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            @if(isset($product->id) && $product->getDefaultImage('large'))
                                <img src="{{ $product->getDefaultImage('large') }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="bg-gray-300 h-full w-full flex items-center justify-center">
                                    <span class="text-gray-600">Image bientôt disponible</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="text-gray-600">{{ number_format($product->price, 2) }}€</p>
                    @if(isset($product->id))
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('shop') }}" class="bg-white border-2 border-black text-black px-8 py-3 text-lg font-medium hover:bg-black hover:text-white transition-colors duration-300 cursor-pointer inline-block">
                    Voir toute la collection
                </a>
            </div>
        </div>
    </section>
</div>
