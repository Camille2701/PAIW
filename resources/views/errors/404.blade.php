@extends('layouts.web')

@section('title', 'Page non trouvée - PAIW')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Illustration 404 -->
        <div class="mb-8">
            <div class="text-8xl font-bold text-gray-300 mb-4">404</div>
            <div class="w-32 h-32 mx-auto mb-6">
                <svg class="w-full h-full text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Page non trouvée</h1>
            <p class="text-lg text-gray-600 mb-2">
                Oops ! La page que vous recherchez n'existe pas ou a été déplacée.
            </p>
            <p class="text-sm text-gray-500">
                Vérifiez l'URL ou naviguez vers une autre page.
            </p>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <a href="/"
               class="inline-flex items-center justify-center w-full px-6 py-3 bg-black text-white font-medium rounded-lg hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Retour à l'accueil
            </a>

            <a href="/shop"
               class="inline-flex items-center justify-center w-full px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Découvrir la boutique
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
