<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutPage extends Component
{
    // Informations de livraison
    public $first_name = '';
    public $last_name = '';
    public $street = '';
    public $apartment = '';
    public $city = '';
    public $country = '';
    public $postal_code = '';

    // Coupon
    public $coupon_code = '';

    // Données du panier
    public $cartItems;
    public $totalPrice = 0;
    public $totalQuantity = 0;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function mount()
    {
        // Charger les données du panier
        $this->refreshCart();

        // Rediriger vers le panier si celui-ci est vide
        if ($this->totalQuantity === 0) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide. Ajoutez des produits avant de procéder au checkout.');
        }

        // Pré-remplir les informations si l'utilisateur est connecté
        if (Auth::check()) {
            $user = Auth::user();
            $this->first_name = $user->first_name ?? '';
            $this->last_name = $user->last_name ?? '';
            $this->street = $user->street ?? '';
            $this->city = $user->city ?? '';
            $this->country = $user->country ?? 'France';
            $this->postal_code = $user->postal_code ?? '';
        }
    }

    public function refreshCart()
    {
        $this->cartItems = $this->cartService->getCartItems();
        $this->totalPrice = $this->cartService->getTotalPrice();
        $this->totalQuantity = $this->cartService->getTotalQuantity();
    }

    public function applyCoupon()
    {
        // TODO: Logique pour appliquer le coupon
        if ($this->coupon_code) {
            session()->flash('error', 'Code de coupon invalide.');
        }
    }

    public function proceedToPayment()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'street.required' => 'L\'adresse est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'country.required' => 'Le pays est obligatoire.',
            'postal_code.required' => 'Le code postal est obligatoire.',
        ]);

        // Sauvegarder automatiquement les informations pour l'utilisateur connecté
        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'street' => $this->street,
                'city' => $this->city,
                'country' => $this->country,
                'postal_code' => $this->postal_code,
            ]);
        }

        // TODO: Rediriger vers la page de paiement
        session()->flash('success', 'Informations de livraison validées !');
    }

    public function render()
    {
        return view('livewire.checkout-page')
            ->layout('layouts.app');
    }
}
