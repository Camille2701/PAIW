@extends('layouts.web')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles et préférences</p>
        </div>

        <!-- Navigation des sections -->
        <div class="mb-8">
            <nav class="flex space-x-8 border-b border-gray-200" aria-label="Tabs">
                <a href="/profile"
                   class="border-b-2 border-blue-500 text-blue-600 py-2 px-1 font-medium text-sm flex items-center space-x-2">
                    <span>👤</span>
                    <span>Profil</span>
                </a>
                <a href="/profile/security"
                   class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 font-medium text-sm flex items-center space-x-2">
                    <span>🔒</span>
                    <span>Sécurité</span>
                </a>
                <a href="/profile/orders"
                   class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 font-medium text-sm flex items-center space-x-2">
                    <span>📦</span>
                    <span>Commandes</span>
                </a>
            </nav>
        </div>

        <!-- Messages de succès -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche - Avatar et informations de base -->
            <div class="lg:col-span-1">
                <!-- Carte Avatar -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <img src="{{ $user->getAvatarThumbUrl() }}"
                                 alt="Avatar"
                                 class="w-24 h-24 rounded-full border-2 border-gray-200 cursor-pointer hover:border-gray-300 transition-colors"
                                 onclick="openAvatarModal()">
                            <button class="absolute -bottom-1 -right-1 bg-blue-600 text-white rounded-full p-1.5 hover:bg-blue-700 transition-colors"
                                    onclick="openAvatarModal()">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <button onclick="openAvatarModal()"
                                class="mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Modifier la photo
                        </button>
                    </div>
                </div>

                <!-- Carte Statistiques -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations du compte</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Membre depuis</span>
                            <span class="font-medium">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date d'inscription</span>
                            <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Informations détaillées -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informations personnelles</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pseudo</label>
                                <p class="text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                            @if($user->first_name || $user->last_name)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                <p class="text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Adresse de livraison -->
                <div class="bg-white rounded-lg shadow border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Adresse de livraison</h3>
                    </div>
                    <div class="p-6">
                        @if($user->street || $user->postal_code || $user->department || $user->country)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($user->street)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                    <p class="text-gray-900">{{ $user->street }}</p>
                                </div>
                                @endif

                                @if($user->postal_code)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                    <p class="text-gray-900">{{ $user->postal_code }}</p>
                                </div>
                                @endif

                                @if($user->department)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                    <p class="text-gray-900">{{ $user->department }}</p>
                                </div>
                                @endif

                                @if($user->country)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                                    <p class="text-gray-900">{{ $user->country }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Aucune adresse enregistrée</p>
                                <p class="text-sm text-gray-400 mt-1">Ajoutez votre adresse de livraison pour faciliter vos commandes</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Modifier mon profil
                        </button>
                        <button onclick="openAvatarModal()"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                            Changer ma photo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'avatar -->
    @livewire('avatar-modal')
</div>

<script>
    // Fonction pour ouvrir la modal d'avatar
    function openAvatarModal() {
        Livewire.dispatch('openModal');
    }
</script>
@endsection
