@extends('layouts.web')

@section('title', 'Service indisponible - PAIW')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Illustration 503 -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-blue-300 mb-4">503</div>
            <div class="w-32 h-32 mx-auto mb-6">
                <svg class="w-full h-full text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Service indisponible</h1>
            <p class="text-lg text-gray-600 mb-2">
                Le site est temporairement en maintenance.
            </p>
            <p class="text-sm text-gray-500">
                Nous effectuons des améliorations pour vous offrir une meilleure expérience. Revenez bientôt !
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
        </div>
    </div>
</div>
@endsection
