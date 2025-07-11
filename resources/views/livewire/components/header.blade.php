<header class="bg-white shadow-sm border-b">
    <div class="bg-black text-white text-center py-2">
        <p class="text-sm">LIVRAISON GRATUITE SUR TOUS VOS VÊTEMENTS VINTAGE FEV 25-26</p>
    </div>

    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold text-black">PAIW</a>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex space-x-8">
                <a href="/shop" class="text-gray-900 hover:text-gray-600 px-3 py-2 text-sm font-medium">Boutique</a>
                <a href="/histoire" class="text-gray-900 hover:text-gray-600 px-3 py-2 text-sm font-medium">Histoire</a>
                <a href="/a-propos" class="text-gray-900 hover:text-gray-600 px-3 py-2 text-sm font-medium">À Propos</a>
            </div>

            <!-- Recherche et actions -->
            <div class="flex items-center space-x-4">
                <!-- Barre de recherche -->
                <div class="hidden md:flex relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model="searchQuery"
                        wire:keydown.enter="search"
                        placeholder="Rechercher..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-black focus:border-black sm:text-sm"
                    >
                </div>

                <!-- Panier -->
                <button class="relative text-gray-900 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l1.5-6m12.5 0v0a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h12z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 h-4 w-4 bg-black text-white rounded-full text-xs flex items-center justify-center">0</span>
                </button>

                <!-- Connexion -->
                <a href="/login" class="text-gray-900 hover:text-gray-600 text-sm font-medium">Se connecter</a>
            </div>

            <!-- Menu mobile -->
            <div class="md:hidden">
                <button type="button" class="text-gray-900 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>
