@extends('layouts.web')

@section('title', 'Session expirée - PAIW')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-orange-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Illustration 419 -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-yellow-300 mb-4">419</div>
            <div class="w-32 h-32 mx-auto mb-6">
                <svg class="w-full h-full text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Session expirée</h1>
            <p class="text-lg text-gray-600 mb-2">
                Votre session a expiré pour des raisons de sécurité.
            </p>
            <p class="text-sm text-gray-500">
                Veuillez actualiser la page et réessayer.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <button onclick="window.location.reload()"
                    class="inline-flex items-center justify-center w-full px-6 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Actualiser la page
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
