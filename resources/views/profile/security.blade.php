@extends('layouts.app')

@section('title', 'Sécurité - Mon compte')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de la page -->
        <div class="mb-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="/profile" class="text-gray-500 hover:text-gray-700 text-sm">
                            👤 Profil
                        </a>
                    </li>
                    <li>
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 text-sm font-medium">🔒 Sécurité</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Sécurité</h1>
            <p class="mt-2 text-gray-600">Gérez la sécurité de votre compte et vos informations personnelles</p>
        </div>

        <!-- Navigation des sections -->
        <div class="mb-6">
            <nav class="flex space-x-8 border-b border-gray-200" aria-label="Tabs">
                <a href="/profile" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    👤 Profil
                </a>
                <a href="/profile/security" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    🔒 Sécurité
                </a>
                <a href="/profile/orders" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    📦 Commandes
                </a>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="space-y-6">
            <!-- Changement de mot de passe -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">🔑 Mot de passe</h3>
                    <p class="mt-1 text-sm text-gray-600">Modifiez votre mot de passe pour sécuriser votre compte</p>
                </div>
                <div class="px-6 py-6">
                    <form class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="new_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Mettre à jour le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Authentification à deux facteurs -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">🛡️ Authentification à deux facteurs</h3>
                    <p class="mt-1 text-sm text-gray-600">Renforcez la sécurité de votre compte avec la 2FA</p>
                </div>
                <div class="px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">État : <span class="text-red-600">Désactivée</span></p>
                            <p class="text-sm text-gray-600">Activez l'authentification à deux facteurs pour plus de sécurité</p>
                        </div>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Activer la 2FA
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sessions actives -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">💻 Sessions actives</h3>
                    <p class="mt-1 text-sm text-gray-600">Gérez vos sessions de connexion actives</p>
                </div>
                <div class="px-6 py-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Session actuelle</p>
                                    <p class="text-sm text-gray-600">Windows - Chrome • France • Maintenant</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Actuelle
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Déconnecter toutes les autres sessions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
