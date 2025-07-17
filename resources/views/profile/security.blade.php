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
            <nav class="flex space-x-8 border-b border-gray-200" aria-label="Tabs">
                <a href="/profile"
                   class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 font-medium text-sm flex items-center space-x-2">
                    <span>👤</span>
                    <span>Profil</span>
                </a>
                <a href="/profile/security"
                   class="border-b-2 border-blue-500 text-blue-600 py-2 px-1 font-medium text-sm flex items-center space-x-2">
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
            <!-- Colonne gauche - Statut de sécurité -->
            <div class="lg:col-span-1">
                <!-- Carte Statut Email -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Vérification Email</h3>
                    </div>

                    @if(auth()->user()->email_verified_at)
                        <div class="flex items-center p-3 bg-green-50 rounded-lg">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-green-800">Email vérifié</p>
                                <p class="text-sm text-green-600">Vérifié le {{ auth()->user()->email_verified_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                <div>
                                    <p class="font-medium text-red-800">Email non vérifié</p>
                                    <p class="text-sm text-red-600">Vérifiez votre email pour sécuriser votre compte</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 cursor-pointer">
                                Renvoyer l'email de vérification
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Carte Niveau de sécurité -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Niveau de sécurité</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Mot de passe</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ Configuré
                            </span>
                        </div>
                        @if(auth()->user()->email_verified_at)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Email vérifié</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ Vérifié
                            </span>
                        </div>
                        @else
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">Email vérifié</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ✗ Non vérifié
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Changement de mot de passe -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-orange-50 border-b border-gray-100 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Changer le mot de passe</h3>
                        </div>
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
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                                               required>
                                        @error('current_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe *</label>
                                        <input type="password"
                                               name="password"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
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
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               required>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-8">
                                    <a href="{{ route('profile.security') }}"
                                       class="px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-300 font-medium">
                                        Annuler
                                    </a>
                                    <button type="submit"
                                            class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                        Changer le mot de passe
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Mode affichage -->
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Sécurisez votre compte</h4>
                                <p class="text-gray-600 mb-6">Changez régulièrement votre mot de passe pour maintenir la sécurité de votre compte</p>
                                <a href="{{ route('profile.security', ['edit' => 'password']) }}"
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-lg transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-3.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Changer mon mot de passe
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
