<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\ShopPage;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\OrderConfirmation;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmailVerificationController;

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
    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Routes pour la sécurité
    Route::get('/profile/security', [SecurityController::class, 'show'])->name('profile.security');
    Route::put('/profile/security', [SecurityController::class, 'updatePassword'])->name('profile.security.update');

    // Routes pour les commandes
    Route::get('/profile/orders', [OrderController::class, 'index'])->name('profile.orders');

    // Route pour la vérification d'email
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
         ->middleware('throttle:6,1')
         ->name('verification.send');
});
