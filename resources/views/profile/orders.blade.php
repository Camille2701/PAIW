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
            <div class="bg-white border border-gray-200 shadow-sm">
                <nav class="flex" aria-label="Tabs">
                    <a href="/profile"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">
                        Profil
                    </a>
                    <a href="/profile/security"
                       class="flex-1 border-r border-gray-200 px-6 py-4 text-center text-sm font-medium text-gray-700 hover:text-black hover:bg-gray-50 transition-colors">
                        Sécurité
                    </a>
                    <a href="/profile/orders"
                       class="flex-1 px-6 py-4 text-center text-sm font-medium bg-black text-white">
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

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
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
                <div class="bg-white border border-gray-200 shadow-sm p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <h3 class="text-lg font-medium text-black">Résumé</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">Total commandes</span>
                            <span class="font-semibold text-black">{{ $totalOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">En cours</span>
                            <span class="font-semibold text-black">{{ $pendingOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-700 font-medium">Livrées</span>
                            <span class="font-semibold text-black">{{ $deliveredOrders }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 bg-gray-50 px-3 -mx-3">
                            <span class="text-black font-medium">Total dépensé</span>
                            <span class="font-bold text-black">{{ number_format($totalSpent, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite - Liste des commandes -->
            <div class="lg:col-span-3">
                <div class="bg-white border border-gray-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-black">Historique des commandes</h3>
                            <!-- Filtres -->
                            <div class="flex space-x-2">
                                <select id="statusFilter" class="text-sm border border-gray-300 px-3 py-1 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
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
                            <div class="order-item border border-gray-200 rounded-lg p-6 mb-4 hover:shadow-md transition-shadow"
                                 data-status="{{ $order->status }}"
                                 onclick="toggleOrderDetails({{ $order->id }})">
                                <!-- En-tête de commande -->
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Commande #{{ $order->id }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium text-gray-700">
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
                                        <p class="text-lg font-bold text-black mt-1">{{ number_format($order->total_price, 2) }}€</p>
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
                                        <button onclick="event.stopPropagation(); toggleOrderDetails({{ $order->id }})" class="text-black hover:text-gray-700 text-sm font-medium cursor-pointer border-b border-black hover:border-gray-700 transition-colors">
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

                                    <!-- Bouton d'annulation pour les commandes payées -->
                                    @if($order->status === 'paid')
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <div class="flex justify-end">
                                                <button onclick="event.stopPropagation(); showCancelConfirmation({{ $order->id }})"
                                                        class="inline-flex items-center px-4 py-2 bg-black text-white text-sm font-medium hover:bg-gray-800 transition-colors duration-200 cursor-pointer">
                                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Annuler la commande
                                                </button>
                                            </div>

                                            <!-- Confirmation d'annulation (cachée par défaut) -->
                                            <div id="cancel-confirmation-{{ $order->id }}" class="cancel-confirmation hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg" onclick="event.stopPropagation()">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <h3 class="text-sm font-medium text-red-800">
                                                            Confirmer l'annulation
                                                        </h3>
                                                        <div class="mt-2 text-sm text-red-700">
                                                            <p>Êtes-vous certain de vouloir annuler cette commande ? Cette action est irréversible et le stock sera automatiquement restauré.</p>
                                                        </div>
                                                        <div class="mt-4 flex space-x-3">
                                                            <button onclick="event.stopPropagation(); confirmCancelOrder({{ $order->id }})"
                                                                    class="bg-black hover:bg-gray-800 text-white px-4 py-2 text-sm font-medium transition-colors duration-200 cursor-pointer">
                                                                Oui, annuler la commande
                                                            </button>
                                                            <button onclick="event.stopPropagation(); hideCancelConfirmation({{ $order->id }})"
                                                                    class="bg-white hover:bg-gray-50 text-black border border-gray-300 px-4 py-2 text-sm font-medium transition-colors duration-200 cursor-pointer">
                                                                Garder la commande
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                                   class="inline-flex items-center px-6 py-3 bg-white border-2 border-black text-black font-medium hover:bg-black hover:text-white transition-colors duration-200">
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

// Fonction pour afficher la confirmation d'annulation
function showCancelConfirmation(orderId) {
    // Masquer toutes les autres confirmations
    document.querySelectorAll('.cancel-confirmation').forEach(function(confirmation) {
        confirmation.classList.add('hidden');
    });

    // Afficher la confirmation pour cette commande
    const confirmationElement = document.getElementById('cancel-confirmation-' + orderId);
    confirmationElement.classList.remove('hidden');

    // Animation d'apparition
    confirmationElement.style.opacity = '0';
    confirmationElement.style.transform = 'translateY(-10px)';
    setTimeout(function() {
        confirmationElement.style.opacity = '1';
        confirmationElement.style.transform = 'translateY(0)';
        confirmationElement.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out';
    }, 10);
}

// Fonction pour masquer la confirmation d'annulation
function hideCancelConfirmation(orderId) {
    const confirmationElement = document.getElementById('cancel-confirmation-' + orderId);
    confirmationElement.style.opacity = '0';
    confirmationElement.style.transform = 'translateY(-10px)';
    setTimeout(function() {
        confirmationElement.classList.add('hidden');
    }, 300);
}

// Fonction pour confirmer l'annulation d'une commande
function confirmCancelOrder(orderId) {
    // Créer un formulaire pour la soumission POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/orders/' + orderId + '/cancel';

    // Ajouter le token CSRF
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);

    // Ajouter le formulaire au body et le soumettre
    document.body.appendChild(form);
    form.submit();
}
</script>

@endsection
