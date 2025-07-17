<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\HomePage;
use App\Livewire\ShopPage;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\OrderConfirmation;

Route::get('/', HomePage::class)->name('home');
Route::get('/shop', function() {
    return redirect('/shop/men');
})->name('shop');
Route::get('/shop/men', ShopPage::class)->name('shop.men');
Route::get('/shop/women', ShopPage::class)->name('shop.women');

// Routes pour les pages produit
Route::get('/shop/men/{product:slug}', ProductPage::class)->name('product.men');
Route::get('/shop/women/{product:slug}', ProductPage::class)->name('product.women');

// Route pour la page panier (Livewire)
Route::get('/cart', CartPage::class)->name('cart.index');
Route::get('/panier', function() {
    return redirect('/cart');
})->name('panier');

// Route pour le checkout
Route::get('/checkout', CheckoutPage::class)->name('checkout');

// Route pour la confirmation de commande
Route::get('/order/confirmation/{orderId}', OrderConfirmation::class)->name('order.confirmation');

// Routes pour le profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return view('profile.profile', ['user' => Auth::user()]);
    })->name('profile');

    Route::put('/profile', function() {
        $user = Auth::user();
        $section = request('section');

        if ($section === 'personal') {
            $validated = request()->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
            ]);
        } elseif ($section === 'address') {
            $validated = request()->validate([
                'street' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:10',
                'department' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
            ]);
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès !');
    })->name('profile.update');

    Route::get('/profile/security', function() {
        return view('profile.security', ['user' => Auth::user()]);
    })->name('profile.security');

    Route::get('/profile/orders', function() {
        return view('profile.orders', ['user' => Auth::user()]);
    })->name('profile.orders');
});
