@extends('layouts.web')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes commandes</h1>
            <p class="text-gray-600">Suivez l'état de vos commandes et consultez votre historique d'achat</p>
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
                   class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 font-medium text-sm flex items-center space-x-2">
                    <span>🔒</span>
                    <span>Sécurité</span>
                </a>
                <a href="/profile/orders"
                   class="border-b-2 border-blue-500 text-blue-600 py-2 px-1 font-medium text-sm flex items-center space-x-2">
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

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Colonne gauche - Statistiques -->
            <div class="lg:col-span-1">
                @php
                    // Calculs basés sur les vraies commandes
                    $totalOrders = $orders->total();
                    $pendingOrders = $orders->where('status', 'pending')->count();
                    $deliveredOrders = $orders->where('status', 'delivered')->count();
                    $totalSpent = $orders->sum('total_price');
                @endphp

                <!-- Carte Statistiques des commandes -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Résumé</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">Total commandes</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $totalOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">En cours</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $pendingOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-gray-600 font-medium">Livrées</span>
                            </div>
                            <span class="font-semibold text-gray-900">{{ $deliveredOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg border border-purple-100">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                <span class="text-purple-700 font-medium">Total dépensé</span>
                            </div>
                            <span class="font-bold text-purple-900">{{ number_format($totalSpent, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Liste des commandes -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Historique des commandes</h3>
                            </div>
                            <!-- Filtres (optionnel pour plus tard) -->
                            <div class="flex space-x-2">
                                <select id="statusFilter" class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="all">Toutes</option>
                                    <option value="pending">En attente</option>
                                    <option value="processing">En cours</option>
                                    <option value="paid">Payées</option>
                                    <option value="shipped">Expédiées</option>
                                    <option value="delivered">Livrées</option>
                                    <option value="cancelled">Annulées</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        @forelse($orders as $order)
                            <div class="order-item border border-gray-200 rounded-lg p-6 mb-4 hover:shadow-md transition-shadow cursor-pointer"
                                 data-status="{{ $order->status }}"
                                 onclick="toggleOrderDetails({{ $order->id }})">
                                <!-- En-tête de commande -->
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Commande #{{ $order->id }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            @switch($order->status ?? 'pending')
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
                                                @case('paid')
                                                    bg-blue-100 text-blue-800
                                                    @break
                                                @default
                                                    bg-gray-100 text-gray-800
                                            @endswitch
                                        ">
                                            @switch($order->status ?? 'pending')
                                                @case('pending')
                                                    En attente
                                                    @break
                                                @case('processing')
                                                    En cours de traitement
                                                    @break
                                                @case('shipped')
                                                    Expédiée
                                                    @break
                                                @case('delivered')
                                                    Livrée
                                                    @break
                                                @case('cancelled')
                                                    Annulée
                                                    @break
                                                @case('paid')
                                                    Payée
                                                    @break
                                                @default
                                                    {{ ucfirst($order->status) }}
                                            @endswitch
                                        </span>
                                        <p class="text-lg font-bold text-gray-900 mt-1">{{ number_format($order->total_price, 2) }}€</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $order->orderItems->count() }} article(s)</p>
                                    </div>
                                </div>

                                <!-- Aperçu rapide des articles (toujours visible) -->
                                <div class="flex items-center space-x-2 mb-4">
                                    @foreach($order->orderItems->take(3) as $item)
                                        <div class="w-12 h-16 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                                            @if($item->productVariant && $item->productVariant->product && $item->productVariant->color)
                                                @php
                                                    $imageUrl = $item->productVariant->product->getImageUrl($item->productVariant->color->id, 'small');
                                                @endphp
                                                @if($imageUrl)
                                                    <img src="{{ $imageUrl }}"
                                                         alt="{{ $item->productVariant->product->name }}"
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">N/A</span>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">N/A</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($order->orderItems->count() > 3)
                                        <div class="w-12 h-16 bg-gray-100 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">+{{ $order->orderItems->count() - 3 }}</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 text-right">
                                        <button class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                            Voir les détails →
                                        </button>
                                    </div>
                                </div>

                                <!-- Détails complets (cachés par défaut) -->
                                <div id="order-details-{{ $order->id }}" class="order-details hidden">
                                    <!-- Items de la commande -->
                                    <div class="space-y-3 mb-4">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                                <div class="w-16 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($item->productVariant && $item->productVariant->product && $item->productVariant->color)
                                                        @php
                                                            $imageUrl = $item->productVariant->product->getImageUrl($item->productVariant->color->id, 'small');
                                                        @endphp
                                                        @if($imageUrl)
                                                            <img src="{{ $imageUrl }}"
                                                                 alt="{{ $item->productVariant->product->name }}"
                                                                 class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                                <span class="text-gray-500 text-xs">N/A</span>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-gray-500 text-xs">N/A</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-medium text-gray-900">
                                                        {{ $item->productVariant->product->name ?? 'Produit supprimé' }}
                                                    </h5>
                                                    <p class="text-sm text-gray-600">
                                                        Taille: {{ $item->productVariant->size->label ?? 'N/A' }} -
                                                        Couleur: {{ $item->productVariant->color->name ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-semibold text-gray-900">{{ number_format($item->unit_price * $item->quantity, 2) }}€</p>
                                                    <p class="text-sm text-gray-600">{{ number_format($item->unit_price, 2) }}€ × {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Informations de livraison et total -->
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h6 class="font-medium text-gray-900 mb-2">Adresse de livraison</h6>
                                                <p class="text-sm text-gray-600">
                                                    {{ $order->first_name }} {{ $order->last_name }}<br>
                                                    {{ $order->street }}<br>
                                                    @if($order->apartment){{ $order->apartment }}<br>@endif
                                                    {{ $order->postal_code }} {{ $order->city }}<br>
                                                    {{ $order->country }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <div class="space-y-1">
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">Sous-total:</span>
                                                        <span class="text-sm">{{ number_format($order->total_price - $order->shipping_price + $order->discount_amount, 2) }}€</span>
                                                    </div>
                                                    @if($order->discount_amount > 0)
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">Réduction:</span>
                                                        <span class="text-sm text-green-600">-{{ number_format($order->discount_amount, 2) }}€</span>
                                                    </div>
                                                    @endif
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">Livraison:</span>
                                                        <span class="text-sm">{{ $order->shipping_price > 0 ? number_format($order->shipping_price, 2) . '€' : 'Gratuit' }}</span>
                                                    </div>
                                                    <div class="flex justify-between font-bold text-lg border-t pt-1">
                                                        <span>Total:</span>
                                                        <span>{{ number_format($order->total_price, 2) }}€</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande pour le moment</h3>
                                <p class="text-gray-600 mb-4">Vous n'avez pas encore passé de commande. Découvrez notre collection et trouvez vos articles préférés !</p>
                                <a href="{{ route('shop') }}"
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Découvrir la boutique
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filtrage des commandes par statut
document.getElementById('statusFilter').addEventListener('change', function() {
    const selectedStatus = this.value;
    const orderItems = document.querySelectorAll('.order-item');

    orderItems.forEach(function(item) {
        if (selectedStatus === 'all') {
            item.style.display = 'block';
        } else {
            const orderStatus = item.getAttribute('data-status');
            if (orderStatus === selectedStatus) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        }
    });
});

// Fonction pour afficher/masquer les détails d'une commande
function toggleOrderDetails(orderId) {
    const detailsElement = document.getElementById('order-details-' + orderId);
    const isHidden = detailsElement.classList.contains('hidden');

    // Masquer tous les autres détails
    document.querySelectorAll('.order-details').forEach(function(detail) {
        detail.classList.add('hidden');
    });

    // Afficher/masquer le détail cliqué
    if (isHidden) {
        detailsElement.classList.remove('hidden');
        // Ajouter une animation d'ouverture
        detailsElement.style.opacity = '0';
        setTimeout(function() {
            detailsElement.style.opacity = '1';
            detailsElement.style.transition = 'opacity 0.3s ease-in-out';
        }, 10);
    } else {
        detailsElement.classList.add('hidden');
    }
}
</script>

@endsection
