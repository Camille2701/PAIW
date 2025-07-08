<header class="bg-white border-b border-gray-200 shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold text-black tracking-tight">PAIW</a>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="{{ request()->is('/') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">Accueil</a>
                <a href="/boutique" class="{{ request()->is('boutique*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">Boutique</a>
                <a href="/a-propos" class="{{ request()->is('a-propos*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">À propos</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <!-- Barre de recherche -->
                <div class="hidden md:flex relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="searchQuery"
                        wire:keydown.enter="search"
                        placeholder="Rechercher..."
                        class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                    >
                </div>

                <!-- Recherche mobile -->
                <button class="md:hidden text-gray-700 hover:text-black transition-colors p-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Compte utilisateur -->
                <a href="/login" class="text-gray-700 hover:text-black transition-colors p-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <!-- Panier -->
                <a href="/panier" class="relative text-gray-700 hover:text-black transition-colors p-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute -top-2 -right-2 h-4 w-4 bg-black text-white rounded-full text-xs flex items-center justify-center font-medium">0</span>
                </a>

                <!-- Menu mobile -->
                <button class="md:hidden text-gray-700 hover:text-black transition-colors p-2">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>
