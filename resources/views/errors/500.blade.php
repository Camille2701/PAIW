@extends('layouts.web')

@section('title', 'Erreur serveur - PAIW')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Illustration 500 -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-red-300 mb-4">500</div>
            <div class="w-32 h-32 mx-auto mb-6">
                <svg class="w-full h-full text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Erreur serveur</h1>
            <p class="text-lg text-gray-600 mb-2">
                Une erreur inattendue s'est produite sur nos serveurs.
            </p>
            <p class="text-sm text-gray-500">
                Nous travaillons à résoudre ce problème. Veuillez réessayer dans quelques instants.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <button onclick="window.location.reload()"
                    class="inline-flex items-center justify-center w-full px-6 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Réessayer
            </button>

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
