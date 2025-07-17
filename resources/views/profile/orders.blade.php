@extends('layouts.app')

@section('title', 'Mes commandes - Mon compte')

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
                        <span class="text-gray-900 text-sm font-medium">📦 Commandes</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Mes commandes</h1>
            <p class="mt-2 text-gray-600">Suivez l'état de vos commandes et consultez votre historique d'achat</p>
        </div>

        <!-- Navigation des sections -->
        <div class="mb-6">
            <nav class="flex space-x-8 border-b border-gray-200" aria-label="Tabs">
                <a href="/profile" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    👤 Profil
                </a>
                <a href="/profile/security" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    🔒 Sécurité
                </a>
                <a href="/profile/orders" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                    📦 Commandes
                </a>
            </nav>
        </div>

        <!-- Filtres de commandes -->
        <div class="mb-6">
            <div class="flex flex-wrap gap-2">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Toutes
                </button>
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300">
                    En cours
                </button>
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300">
                    Livrées
                </button>
                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300">
                    Annulées
                </button>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="space-y-6">
            @php
                // Récupération des commandes de l'utilisateur
                $orders = Auth::user()->orders()->with('orderItems.productVariant.product', 'orderItems.productVariant.color', 'orderItems.productVariant.size')->orderBy('created_at', 'desc')->get();
            @endphp

            @forelse($orders as $order)
                <div class="bg-white shadow rounded-lg">
                    <!-- En-tête de commande -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Commande #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-600">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($order->status)
                                    @case('pending')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @case('processing')
                                        bg-blue-100 text-blue-800
                                        @break
                                    @case('shipped')
                                        bg-purple-100 text-purple-800
                                        @break
                                    @case('delivered')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('cancelled')
                                        bg-red-100 text-red-800
                                        @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch
                            ">
                                @switch($order->status)
                                    @case('pending')
                                        ⏳ En attente
                                        @break
                                    @case('processing')
                                        🔄 En cours
                                        @break
                                    @case('shipped')
                                        🚚 Expédiée
                                        @break
                                    @case('delivered')
                                        ✅ Livrée
                                        @break
                                    @case('cancelled')
                                        ❌ Annulée
                                        @break
                                    @default
                                        {{ $order->status }}
                                @endswitch
                            </span>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ number_format($order->total_price, 2) }} €</p>
                        </div>
                    </div>

                    <!-- Articles de la commande -->
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Image</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item->productVariant->product->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            Couleur: {{ $item->productVariant->color->name }} •
                                            Taille: {{ $item->productVariant->size->label }}
                                        </p>
                                        <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">{{ number_format($item->unit_price, 2) }} €</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="flex space-x-2">
                            @if($order->status === 'delivered')
                                <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    📥 Télécharger la facture
                                </button>
                            @endif
                            @if(in_array($order->status, ['shipped', 'delivered']))
                                <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    📦 Suivre le colis
                                </button>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            @if($order->status === 'pending')
                                <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    ❌ Annuler
                                </button>
                            @endif
                            <button class="text-gray-600 hover:text-gray-700 text-sm font-medium">
                                👁️ Voir les détails
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Message si aucune commande -->
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore passé de commande.</p>
                    <a href="/shop" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                        Découvrir la boutique
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
