
<header class="bg-white border-b border-gray-200 shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold text-black tracking-tight">PAIW</a>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center space-x-8" wire:ignore>
                <a href="/" class="{{ request()->is('/') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">Accueil</a>
                <a href="/shop" class="{{ request()->is('shop*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">Boutique</a>
                <a href="/about" class="{{ request()->is('about*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} text-sm font-medium transition-colors px-3 py-2 rounded-md">À propos</a>
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
                        wire:model="searchQuery"
                        wire:keydown.enter="search"
                        placeholder="Rechercher..."
                        class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                    >
                </div>

                <!-- Recherche mobile -->
                <button class="md:hidden text-gray-700 hover:text-black transition-colors p-2" aria-label="Open search">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Compte utilisateur -->
                @auth
                    <div class="relative">
                        <button wire:click="toggleUserMenu"
                                class="flex items-center space-x-2 text-gray-700 hover:text-black transition-colors p-2 cursor-pointer"
                                aria-label="User menu">
                            <img src="{{ Auth::user()->getAvatarUrl() }}"
                                 alt="Avatar"
                                 class="w-8 h-8 rounded-full border-2 border-gray-200 hover:border-gray-300 transition-colors">
                            <span class="text-sm font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 transition-transform {{ $showUserMenu ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Menu déroulant -->
                        @if($showUserMenu)
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                                 wire:click.outside="closeUserMenu">

                                <a href="/profile"
                                   wire:click="closeUserMenu"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil
                                    </div>
                                </a>

                                <a href="/profile/security"
                                   wire:click="closeUserMenu"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Sécurité
                                    </div>
                                </a>

                                <a href="/profile/orders"
                                   wire:click="closeUserMenu"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Commandes
                                    </div>
                                </a>

                                <div class="border-t border-gray-100"></div>

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer">
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Se déconnecter
                                        </div>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-black transition-colors text-sm">
                        Se connecter
                    </a>
                @endauth

                <!-- Panier -->
                <a href="/cart" class="relative text-gray-700 hover:text-black transition-colors p-2" aria-label="Shopping cart">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @livewire('cart-counter')
                </a>

                <!-- Menu mobile -->
                <div class="relative md:hidden">
                    <button wire:click="toggleMobileMenu"
                            class="text-gray-700 hover:text-black transition-colors p-2 cursor-pointer"
                            aria-label="Toggle mobile menu">
                        @if(!$showMobileMenu)
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        @else
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Menu mobile -->
    @if($showMobileMenu)
        <div class="md:hidden border-t border-gray-200 bg-white" wire:click.outside="closeMobileMenu">
            <div class="px-4 py-3 space-y-1">
                <!-- Navigation links -->
                <a href="/"
                   wire:click="closeMobileMenu"
                   class="block px-3 py-2 text-base font-medium {{ request()->is('/') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} rounded-md transition-colors">
                    Accueil
                </a>

                <a href="/shop"
                   wire:click="closeMobileMenu"
                   class="block px-3 py-2 text-base font-medium {{ request()->is('shop*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} rounded-md transition-colors">
                    Boutique
                </a>

                <a href="/about"
                   wire:click="closeMobileMenu"
                   class="block px-3 py-2 text-base font-medium {{ request()->is('about*') ? 'bg-black text-white' : 'text-gray-700 hover:text-black hover:bg-gray-50' }} rounded-md transition-colors">
                    À propos
                </a>

                <!-- Barre de recherche mobile -->
                <div class="pt-4 pb-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model="searchQuery"
                            wire:keydown.enter="search"
                            placeholder="Rechercher..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                        >
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de recherche pour la page d'accueil -->
    @if($showSearchModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" wire:click="closeModal">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recherche</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-4">Vous recherchez "{{ $searchQuery }}"</p>
                <div class="flex space-x-3">
                    <button wire:click="goToShop" class="flex-1 bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-colors">
                        Voir les produits
                    </button>
                    <button wire:click="closeModal" class="flex-1 border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    @endif
</header>
