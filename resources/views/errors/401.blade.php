@extends('layouts.web')

@section('title', 'Accès non autorisé - PAIW')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-orange-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Illustration 401 -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-red-300 mb-4">401</div>
            <div class="w-32 h-32 mx-auto mb-6">
                <svg class="w-full h-full text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Accès non autorisé</h1>
            <p class="text-lg text-gray-600 mb-2">
                Vous n'avez pas les permissions nécessaires pour accéder à cette page.
            </p>
            <p class="text-sm text-gray-500">
                Connectez-vous ou vérifiez vos autorisations.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            @guest
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center w-full px-6 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 0v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Se connecter
            </a>

            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center w-full px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Créer un compte
            </a>
            @else
            <a href="/profile"
               class="inline-flex items-center justify-center w-full px-6 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Voir mon profil
            </a>
            @endguest

            <a href="/"
               class="inline-flex items-center justify-center w-full px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Retour à l'accueil
            </a>

            <button onclick="history.back()"
                    class="inline-flex items-center justify-center w-full px-6 py-3 text-gray-600 font-medium hover:text-gray-800 transition-colors cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour en arrière
            </button>
        </div>
    </div>
</div>
@endsection
