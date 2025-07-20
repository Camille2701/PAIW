@extends('layouts.web')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Sécurité</h1>
            <p class="text-gray-600">Gérez la sécurité de votre compte et vos paramètres de confidentialité</p>
        </div>

        <!-- Navigation des sections -->
        <div class="mb-8">
            <div class="bg-white border border-gray-200 shadow-sm">
                <nav class="flex" aria-label="Tabs">
                    <a href="/profile"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">
                        Profil
                    </a>
                    <a href="/profile/security"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium bg-black text-white">
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
            <!-- Statut de vérification email -->
            <div class="bg-white border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Vérification Email</h3>
                @if(auth()->user()->email_verified_at)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium text-gray-900">Email vérifié</p>
                            <p class="text-sm text-gray-600">Vérifié le {{ auth()->user()->email_verified_at->format('d/m/Y') }}</p>
                        </div>
                        <span class="text-sm text-gray-600 border border-gray-300 px-3 py-1 rounded">
                            ✓ Configuré
                        </span>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded">
                            <div>
                                <p class="font-medium text-gray-900">Email non vérifié</p>
                                <p class="text-sm text-gray-600">Vérifiez votre email pour sécuriser votre compte</p>
                            </div>
                            <span class="text-sm text-gray-600 border border-gray-300 px-3 py-1 rounded">
                                ✗ Non vérifié
                            </span>
                        </div>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-black hover:bg-gray-800 text-white rounded transition-colors">
                                Renvoyer l'email de vérification
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Niveau de sécurité -->
            <div class="bg-white border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Niveau de sécurité</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-gray-700">Mot de passe</span>
                        <span class="text-sm text-gray-600 border border-gray-300 px-3 py-1 rounded">
                            ✓ Configuré
                        </span>
                    </div>
                    @if(auth()->user()->email_verified_at)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-gray-700">Email vérifié</span>
                        <span class="text-sm text-gray-600 border border-gray-300 px-3 py-1 rounded">
                            ✓ Vérifié
                        </span>
                    </div>
                    @else
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-gray-700">Email vérifié</span>
                        <span class="text-sm text-gray-600 border border-gray-300 px-3 py-1 rounded">
                            ✗ Non vérifié
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Changement de mot de passe -->
            <div class="bg-white border border-gray-200 shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Changer le mot de passe</h3>
                    @if(request('edit') !== 'password')
                        <a href="{{ route('profile.security', ['edit' => 'password']) }}"
                           class="text-sm text-gray-600 hover:text-black border border-gray-300 px-3 py-1 rounded hover:bg-gray-50 transition-colors">
                            Modifier
                        </a>
                    @endif
                </div>
                <div class="p-6">
                    @if(request('edit') === 'password')
                        <!-- Mode édition -->
                        <form action="{{ route('profile.security.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel *</label>
                                    <input type="password"
                                           name="current_password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('current_password') border-red-500 @enderror"
                                           required>
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe *</label>
                                    <input type="password"
                                           name="password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black @error('password') border-red-500 @enderror"
                                           required>
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-gray-500 mt-1">Minimum 8 caractères avec au moins une majuscule et un chiffre</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe *</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                                           required>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <a href="{{ route('profile.security') }}"
                                   class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 bg-black hover:bg-gray-800 text-white rounded transition-colors">
                                    Changer le mot de passe
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Mode affichage -->
                        <div class="text-center py-8">
                            <p class="text-gray-600 mb-4">Changez régulièrement votre mot de passe pour maintenir la sécurité de votre compte</p>
                            <a href="{{ route('profile.security', ['edit' => 'password']) }}"
                               class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded transition-colors">
                                Changer mon mot de passe
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
