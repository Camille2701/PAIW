<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckoutPage extends Component
{
    // Étape actuelle du checkout (1: Adresse, 2: Livraison, 3: Paiement)
    public $currentStep = 1;

    // Informations de livraison
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $street = '';
    public $apartment = '';
    public $city = '';
    public $country = '';
    public $postal_code = '';

    // Options de livraison
    public $shipping_method = 'ups_standard'; // Par défaut UPS Standard (gratuit)
    public $shipping_price = 0;

    // Coupon
    public $coupon_code = '';
    public $coupon_applied = false;
    public $coupon_discount = 0;
    public $coupon_message = '';

    // Paiement
    public $card_holder_name = '';
    public $card_number = '';
    public $card_expiry_month = '';
    public $card_expiry_year = '';
    public $card_cvc = '';
    public $save_card = false;
    public $processing_payment = false;

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
        // Initialiser le prix de livraison
        $this->updateShippingMethod();

        // Charger les données du panier
        $this->refreshCart();

        // Redirection si le panier est vide
        if ($this->cartService->getTotalQuantity() == 0) {
            return redirect()->route('cart');
        }

        // Pré-remplir avec les informations utilisateur si connecté
        if (Auth::check()) {
            $user = Auth::user();
            $this->first_name = $user->first_name ?? '';
            $this->last_name = $user->last_name ?? '';
            $this->email = $user->email ?? '';
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

    public function goToStep($step)
    {
        // Validation avant de changer d'étape
        if ($step > $this->currentStep) {
            if ($this->currentStep == 1) {
                // Valider les informations d'adresse avant de passer à l'étape 2
                $this->proceedToShipping();
                return;
            }
        }

        $this->currentStep = $step;
    }

    public function updateShippingMethod()
    {
        if ($this->shipping_method === 'ups_standard') {
            $this->shipping_price = 0;
        } elseif ($this->shipping_method === 'ups_premium') {
            $this->shipping_price = 4.99;
        }
    }

    public function applyCoupon()
    {
        if (trim($this->coupon_code) === '') {
            $this->coupon_message = 'Veuillez entrer un code de coupon.';
            return;
        }

        if (strtoupper(trim($this->coupon_code)) === 'PAIW10') {
            if (!$this->coupon_applied) {
                $this->coupon_applied = true;
                $this->coupon_discount = 0.10; // 10% de réduction
                $this->coupon_message = 'Coupon appliqué ! 10% de réduction.';
                session()->flash('success', 'Coupon PAIW10 appliqué avec succès !');
            } else {
                $this->coupon_message = 'Ce coupon est déjà appliqué.';
            }
        } else {
            $this->coupon_message = 'Code de coupon invalide.';
            $this->coupon_applied = false;
            $this->coupon_discount = 0;
        }
    }

    public function removeCoupon()
    {
        $this->coupon_applied = false;
        $this->coupon_discount = 0;
        $this->coupon_code = '';
        $this->coupon_message = '';
        session()->flash('success', 'Coupon retiré.');
    }

    public function proceedToShipping()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ];

        $messages = [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'street.required' => 'L\'adresse est obligatoire.',
            'city.required' => 'La ville est obligatoire.',
            'country.required' => 'Le pays est obligatoire.',
            'postal_code.required' => 'Le code postal est obligatoire.',
        ];

        // Ajouter la validation email si l'utilisateur n'est pas connecté
        if (!Auth::check()) {
            $rules['email'] = 'required|email|max:255';
            $messages['email.required'] = 'L\'adresse email est obligatoire.';
            $messages['email.email'] = 'L\'adresse email doit être valide.';
        }

        $this->validate($rules, $messages);

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

        // Passer à l'étape suivante
        $this->currentStep = 2;
    }

    public function proceedToPayment()
    {
        // Mettre à jour le prix de livraison
        $this->updateShippingMethod();

        // Passer à l'étape de paiement
        $this->currentStep = 3;

        session()->flash('success', 'Options de livraison validées !');
    }

    public function getTotalWithShipping()
    {
        $subtotal = $this->totalPrice + $this->shipping_price;

        if ($this->coupon_applied && $this->coupon_discount > 0) {
            $discount = $subtotal * $this->coupon_discount;
            return $subtotal - $discount;
        }

        return $subtotal;
    }

    public function getDiscountAmount()
    {
        if ($this->coupon_applied && $this->coupon_discount > 0) {
            $subtotal = $this->totalPrice + $this->shipping_price;
            return $subtotal * $this->coupon_discount;
        }

        return 0;
    }

    public function processPayment()
    {
        $this->processing_payment = true;

        // Simulation d'un délai de traitement
        sleep(2);

        // Créer la commande
        $order = $this->createOrder();

        if ($order) {
            // Vider le panier après commande réussie
            $this->cartService->clearCart();

            // Rediriger vers la page de confirmation
            return redirect()->route('order.confirmation', $order->id);
        }

        $this->processing_payment = false;
        session()->flash('error', 'Erreur lors du traitement du paiement.');
    }

    private function createOrder()
    {
        try {
            // Créer la commande
            $order = new \App\Models\Order();
            $order->user_id = Auth::check() ? Auth::id() : null;
            $order->total_price = $this->getTotalWithShipping();
            $order->shipping_price = $this->shipping_price;
            $order->discount_amount = $this->getDiscountAmount();
            $order->status = 'paid';
            $order->first_name = $this->first_name;
            $order->last_name = $this->last_name;
            $order->email = Auth::check() ? Auth::user()->email : $this->email;
            $order->street = $this->street;
            $order->apartment = $this->apartment;
            $order->city = $this->city;
            $order->country = $this->country;
            $order->postal_code = $this->postal_code;
            $order->shipping_method = $this->shipping_method;
            $order->coupon_code = $this->coupon_applied ? $this->coupon_code : null;
            $order->save();

            // Créer les items de commande
            foreach ($this->cartItems as $cartItem) {
                $orderItem = new \App\Models\OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_variant_id = $cartItem->product_variant_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->unit_price = $cartItem->productVariant->product->price;
                $orderItem->save();
            }

            return $order;
        } catch (\Exception $e) {
            Log::error('Erreur création commande: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.checkout-page')
            ->layout('layouts.app');
    }
}
