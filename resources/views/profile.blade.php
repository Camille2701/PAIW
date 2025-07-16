@extends('layouts.web')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Messages de succès -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Mon Profil</h1>

            <!-- Avatar cliquable -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img src="{{ $user->getAvatarThumbUrl() }}"
                         alt="Avatar"
                         class="w-20 h-20 rounded-full border-4 border-blue-200 cursor-pointer hover:border-blue-400 transition-colors"
                         onclick="openAvatarModal()">
                    <button class="absolute -bottom-1 -right-1 bg-blue-600 text-white rounded-full p-1 hover:bg-blue-700 transition-colors"
                            onclick="openAvatarModal()">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Cliquez sur votre avatar</p>
                    <p class="text-sm text-gray-500">pour le modifier</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations personnelles</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>

                    @if($user->first_name || $user->last_name)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom et Nom</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Adresse</h2>

                <div class="space-y-4">
                    @if($user->street)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rue</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->street }}</p>
                    </div>
                    @endif

                    @if($user->postal_code)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->postal_code }}</p>
                    </div>
                    @endif

                    @if($user->department)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Département</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->department }}</p>
                    </div>
                    @endif

                    @if($user->country)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pays</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->country }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-500">
                    Membre depuis le {{ $user->created_at->format('d/m/Y') }}
                </p>

                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    Modifier mon profil
                </button>
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
