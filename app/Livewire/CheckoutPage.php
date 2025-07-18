<?php

namespace App\Livewire;

use App\Services\CartService;
use App\Notifications\OrderConfirmation;
use App\Support\GuestUser;
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

        // Récupérer les données de coupon depuis la session (venant du panier)
        if (session()->has('coupon_code')) {
            $this->coupon_code = session('coupon_code');
            $this->coupon_applied = session('coupon_applied', false);
            $this->coupon_discount = session('coupon_discount', 0);
            if ($this->coupon_applied) {
                $this->coupon_message = 'Code promo appliqué avec succès !';
            }
        }

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
            $this->country = $user->country ?? '';
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

                // Synchroniser avec la session
                session([
                    'coupon_code' => strtoupper(trim($this->coupon_code)),
                    'coupon_applied' => true,
                    'coupon_discount' => 0.10
                ]);

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

        // Nettoyer la session
        session()->forget(['coupon_code', 'coupon_applied', 'coupon_discount']);

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

        try {
            // Simulation d'un délai de traitement
            sleep(2);

            // Créer la commande directement sans snapshot pour déboguer
            $order = $this->createOrder();

            if ($order) {
                Log::info('✅ Commande créée avec succès, ID: ' . $order->id);

                // Envoyer l'email de confirmation avec facture PDF
                try {
                    if (Auth::check()) {
                        // Utilisateur connecté
                        Auth::user()->notify(new OrderConfirmation($order));
                    } else {
                        // Utilisateur non connecté - utiliser notre classe GuestUser
                        $guestUser = new GuestUser($this->email, $this->first_name, $this->last_name);
                        $guestUser->notify(new OrderConfirmation($order));
                    }

                    Log::info('📧 Email de confirmation envoyé avec succès');
                } catch (\Exception $e) {
                    Log::error('❌ Erreur envoi email: ' . $e->getMessage());
                    // Ne pas bloquer le processus si l'email échoue
                }

                // Vider le panier APRÈS la création réussie de la commande
                $this->cartService->clearCart();

                // Nettoyer les données de coupon de la session
                session()->forget(['coupon_code', 'coupon_applied', 'coupon_discount']);

                // Rediriger vers la page de confirmation
                return redirect()->route('order.confirmation', $order->id);
            }

            $this->processing_payment = false;
            session()->flash('error', 'Erreur lors du traitement du paiement.');
        } catch (\Exception $e) {
            $this->processing_payment = false;
            Log::error('Erreur processPayment: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors du traitement du paiement: ' . $e->getMessage());
        }
    }

    private function createOrder()
    {
        Log::info('🚀 DÉBUT CRÉATION COMMANDE');

        try {
            // Étape 1: Récupérer les items du panier
            Log::info('📦 Récupération des items du panier...');
            $cartItems = $this->cartService->getCartItems();
            Log::info('✅ Items trouvés dans le panier: ' . $cartItems->count());

            if ($cartItems->isEmpty()) {
                Log::error('❌ ERREUR: Panier vide!');
                return null;
            }

            // Étape 2: Créer l'Order
            Log::info('📝 Création de l\'order...');
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

            Log::info('✅ Order créé avec ID: ' . $order->id);

            // Étape 3: Créer les OrderItems
            Log::info('🛍️ Création des OrderItems...');
            $itemsCreated = 0;

            foreach ($cartItems as $index => $cartItem) {
                Log::info("🔍 Item $index - ProductVariant ID: " . ($cartItem->product_variant_id ?? 'NULL') . " - Quantity: " . ($cartItem->quantity ?? 'NULL'));

                // Validation de base
                if (!isset($cartItem->product_variant_id) || !isset($cartItem->quantity)) {
                    Log::error("❌ Item $index INVALIDE - données manquantes");
                    continue;
                }

                // Récupérer le ProductVariant
                $productVariant = \App\Models\ProductVariant::with('product')->find($cartItem->product_variant_id);

                if (!$productVariant) {
                    Log::error("❌ ProductVariant introuvable pour ID: " . $cartItem->product_variant_id);
                    continue;
                }

                if (!$productVariant->product) {
                    Log::error("❌ Product introuvable pour ProductVariant ID: " . $cartItem->product_variant_id);
                    continue;
                }

                Log::info("✅ ProductVariant OK - Product: " . $productVariant->product->name . " - Prix: " . $productVariant->product->price);

                // Créer l'OrderItem
                try {
                    $orderItem = new \App\Models\OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_variant_id = $cartItem->product_variant_id;
                    $orderItem->quantity = $cartItem->quantity;
                    $orderItem->unit_price = $productVariant->product->price;

                    // VÉRIFICATION AVANT SAUVEGARDE
                    if (!$orderItem->order_id || !$orderItem->product_variant_id || !$orderItem->quantity || !$orderItem->unit_price) {
                        Log::error("❌ OrderItem invalide avant sauvegarde:", [
                            'order_id' => $orderItem->order_id,
                            'product_variant_id' => $orderItem->product_variant_id,
                            'quantity' => $orderItem->quantity,
                            'unit_price' => $orderItem->unit_price
                        ]);
                        continue;
                    }

                    $orderItem->save();
                    $itemsCreated++;

                    Log::info("✅ OrderItem #{$orderItem->id} créé pour Order #{$order->id}");

                } catch (\Exception $e) {
                    Log::error("❌ ERREUR création OrderItem: " . $e->getMessage());
                    Log::error("Stack: " . $e->getTraceAsString());
                }
            }

            // Étape 4: Diminution du stock (car commande payée)
            Log::info("📦 Diminution du stock...");
            foreach ($cartItems as $cartItem) {
                if ($cartItem->productVariant) {
                    $productVariant = $cartItem->productVariant;
                    $oldStock = $productVariant->stock;
                    $newStock = max(0, $oldStock - $cartItem->quantity); // Éviter stock négatif

                    $productVariant->stock = $newStock;
                    $productVariant->save();

                    Log::info("📉 Stock variant #{$productVariant->id}: {$oldStock} → {$newStock} (-{$cartItem->quantity})");
                }
            }

            // Étape 5: Vérification finale
            Log::info("🔍 Vérification finale...");
            $finalCount = \App\Models\OrderItem::where('order_id', $order->id)->count();
            Log::info("📊 Items créés: $itemsCreated - Items en DB: $finalCount");

            if ($finalCount === 0) {
                Log::error("🚨 ÉCHEC CRITIQUE: Aucun OrderItem créé!");
            } else {
                Log::info("🎉 SUCCÈS: $finalCount OrderItems créés!");
            }

            Log::info('🏁 FIN CRÉATION COMMANDE');
            return $order;

        } catch (\Exception $e) {
            Log::error("💥 ERREUR GLOBALE: " . $e->getMessage());
            Log::error("Stack: " . $e->getTraceAsString());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.checkout-page')
            ->layout('layouts.app');
    }
}
