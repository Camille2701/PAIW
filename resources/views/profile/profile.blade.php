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

        <!-- Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche - Avatar et informations de base -->
            <div class="lg:col-span-1">
                <!-- Carte Avatar -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mb-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-50 to-indigo-100 p-1">
                                <img src="{{ $user->getAvatarThumbUrl() }}"
                                     alt="Avatar"
                                     class="w-full h-full rounded-full object-cover cursor-pointer hover:shadow-lg transition-all duration-300"
                                     onclick="openAvatarModal()">
                            </div>
                            <button class="absolute -bottom-2 -right-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full p-2 shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300"
                                    onclick="openAvatarModal()">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <h2 class="mt-6 text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500 mt-1">{{ $user->email }}</p>
                        <button onclick="openAvatarModal()"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 text-sm font-medium rounded-lg hover:from-blue-100 hover:to-indigo-100 transition-all duration-300 cursor-pointer">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Modifier la photo
                        </button>
                    </div>
                </div>

                <!-- Carte Statistiques -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Informations du compte</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">Membre depuis</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">Compte créé le</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if($user->updated_at && $user->updated_at != $user->created_at)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">Dernière modification</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Informations détaillées -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Informations personnelles</h3>
                        </div>
                        @if(request('edit') !== 'personal')
                            <a href="{{ route('profile', ['edit' => 'personal']) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-white text-blue-600 text-sm font-medium rounded-lg border border-blue-200 hover:bg-blue-50 transition-all duration-300">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Modifier
                            </a>
                        @endif
                    </div>
                    <div class="p-6">
                        @if(request('edit') === 'personal')
                            <!-- Mode édition -->
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="section" value="personal">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pseudo *</label>
                                        <input type="text"
                                               name="name"
                                               value="{{ old('name', $user->name) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                               required>
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail *</label>
                                        <input type="email"
                                               name="email"
                                               value="{{ old('email', $user->email) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                               required>
                                        @error('email')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                        <input type="text"
                                               name="first_name"
                                               value="{{ old('first_name', $user->first_name) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror">
                                        @error('first_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom de famille</label>
                                        <input type="text"
                                               name="last_name"
                                               value="{{ old('last_name', $user->last_name) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror">
                                        @error('last_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <a href="{{ route('profile') }}"
                                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                        Annuler
                                    </a>
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        Sauvegarder
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Mode affichage -->
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
                        @endif
                    </div>
                </div>

                <!-- Adresse de livraison -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Adresse de livraison</h3>
                        </div>
                        @if(request('edit') !== 'address')
                            <a href="{{ route('profile', ['edit' => 'address']) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-white text-green-600 text-sm font-medium rounded-lg border border-green-200 hover:bg-green-50 transition-all duration-300">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Modifier
                            </a>
                        @endif
                    </div>
                    <div class="p-6">
                        @if(request('edit') === 'address')
                            <!-- Mode édition -->
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="section" value="address">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                        <input type="text"
                                               name="street"
                                               value="{{ old('street', $user->street) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('street')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                        <input type="text"
                                               name="postal_code"
                                               value="{{ old('postal_code', $user->postal_code) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('postal_code')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                        <input type="text"
                                               name="department"
                                               value="{{ old('department', $user->department) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('department')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                                        <select name="country"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner une option</option>
                                            <option value="France" {{ old('country', $user->country) === 'France' ? 'selected' : '' }}>France</option>
                                            <option value="Suisse" {{ old('country', $user->country) === 'Suisse' ? 'selected' : '' }}>Suisse</option>
                                            <option value="Belgique" {{ old('country', $user->country) === 'Belgique' ? 'selected' : '' }}>Belgique</option>
                                        </select>
                                        @error('country')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <a href="{{ route('profile') }}"
                                       class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                        Annuler
                                    </a>
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        Sauvegarder
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Mode affichage -->
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
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">Aucune adresse enregistrée</p>
                                    <p class="text-sm text-gray-400 mt-2">Ajoutez votre adresse de livraison pour faciliter vos commandes</p>
                                </div>
                            @endif
                        @endif
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
