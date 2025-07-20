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
            <div class="bg-white border border-gray-200 shadow-sm">
                <nav class="flex" aria-label="Tabs">
                    <a href="/profile"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium bg-black text-white">
                        Profil
                    </a>
                    <a href="/profile/security"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">
                        Sécurité
                    </a>
                    <a href="/profile/orders"
                       class="flex-1 px-6 py-4 text-center text-sm font-medium text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">
                        Commandes
                    </a>
                </nav>
            </div>
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
        <div class="space-y-6">
            <!-- Section Avatar et nom -->
            <div class="bg-white border border-gray-200 shadow-sm p-6">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="{{ $user->getAvatarThumbUrl() }}"
                             alt="Avatar"
                             class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                        <button onclick="openAvatarModal()"
                                class="absolute -bottom-1 -right-1 bg-black text-white rounded-full p-1.5 border-2 border-white hover:bg-gray-800 transition-colors">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500">Membre depuis {{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="bg-white border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Informations personnelles</h3>
                    @if(request('edit') !== 'personal')
                        <a href="{{ route('profile', ['edit' => 'personal']) }}"
                           class="text-sm text-gray-600 hover:text-black border border-gray-300 px-3 py-1 rounded hover:bg-gray-50 transition-colors">
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
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('name') border-red-500 @enderror"
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
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('email') border-red-500 @enderror"
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
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('first_name') border-red-500 @enderror">
                                    @error('first_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom de famille</label>
                                    <input type="text"
                                           name="last_name"
                                           value="{{ old('last_name', $user->last_name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('last_name') border-red-500 @enderror">
                                    @error('last_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <a href="{{ route('profile') }}"
                                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 bg-black hover:bg-gray-800 text-white rounded transition-colors">
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
            <div class="bg-white border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Adresse de livraison</h3>
                    @if(request('edit') !== 'address')
                        <a href="{{ route('profile', ['edit' => 'address']) }}"
                           class="text-sm text-gray-600 hover:text-black border border-gray-300 px-3 py-1 rounded hover:bg-gray-50 transition-colors">
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
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
                                    @error('street')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                    <input type="text"
                                           name="postal_code"
                                           value="{{ old('postal_code', $user->postal_code) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
                                    @error('postal_code')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                    <input type="text"
                                           name="department"
                                           value="{{ old('department', $user->department) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
                                    @error('department')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                                    <select name="country"
                                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black">
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
                                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 bg-black hover:bg-gray-800 text-white rounded transition-colors">
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
                            <div class="text-center py-8">
                                <p class="text-gray-500">Aucune adresse enregistrée</p>
                                <p class="text-sm text-gray-400 mt-1">Ajoutez votre adresse de livraison pour faciliter vos commandes</p>
                            </div>
                        @endif
                    @endif
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
