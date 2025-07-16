<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartPage extends Component
{
    public $cartItems;
    public $totalPrice;
    public $totalQuantity;

    // Propriétés pour la modal de suppression
    public $showDeleteModal = false;
    public $itemToDelete = null;
    public $itemToDeleteName = '';

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $cartService = app(CartService::class);
        $this->cartItems = $cartService->getCartItems();
        $this->totalPrice = $cartService->getTotalPrice();
        $this->totalQuantity = $cartService->getTotalQuantity();
    }

    public function increaseQuantity($productVariantId)
    {
        $cartService = app(CartService::class);

        // Trouver l'item actuel
        $currentItem = $this->cartItems->firstWhere('product_variant_id', $productVariantId);
        if ($currentItem) {
            // Vérifier le stock disponible
            $availableStock = $currentItem->productVariant->stock ?? 0;

            if ($currentItem->quantity < $availableStock) {
                $cartService->updateQuantity($productVariantId, $currentItem->quantity + 1);
                $this->refreshCart();
                $this->dispatch('cartUpdated'); // Pour mettre à jour le compteur
            } else {
                // Afficher un message d'erreur si pas assez de stock
                session()->flash('error', 'Stock insuffisant. Seulement ' . $availableStock . ' article(s) disponible(s).');
            }
        }
    }

    public function decreaseQuantity($productVariantId)
    {
        $cartService = app(CartService::class);

        // Trouver l'item actuel
        $currentItem = $this->cartItems->firstWhere('product_variant_id', $productVariantId);
        if ($currentItem) {
            if ($currentItem->quantity > 1) {
                // Si quantité > 1, diminuer normalement
                $cartService->updateQuantity($productVariantId, $currentItem->quantity - 1);
                $this->refreshCart();
                $this->dispatch('cartUpdated'); // Pour mettre à jour le compteur
            } else {
                // Si quantité = 1, déclencher la modal de suppression
                $this->confirmDeleteItem($productVariantId);
            }
        }
    }

    public function confirmDeleteItem($productVariantId)
    {
        // Trouver l'item pour récupérer le nom du produit
        $item = $this->cartItems->firstWhere('product_variant_id', $productVariantId);
        if ($item) {
            $this->itemToDelete = $productVariantId;
            $this->itemToDeleteName = $item->productVariant->product->name ?? 'Produit';
            $this->showDeleteModal = true;
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->itemToDelete = null;
        $this->itemToDeleteName = '';
    }

    public function removeItem()
    {
        if ($this->itemToDelete) {
            $cartService = app(CartService::class);
            $cartService->removeFromCart($this->itemToDelete);
            $this->refreshCart();
            $this->dispatch('cartUpdated'); // Pour mettre à jour le compteur

            session()->flash('success', 'Produit supprimé du panier');

            // Réinitialiser la modal
            $this->cancelDelete();
        }
    }

    public function clearCart()
    {
        $cartService = app(CartService::class);
        $cartService->clearCart();
        $this->refreshCart();
        $this->dispatch('cartUpdated'); // Pour mettre à jour le compteur

        session()->flash('success', 'Panier vidé');
    }

    public function render()
    {
        return view('livewire.cart-page')
            ->layout('layouts.app');
    }
}
