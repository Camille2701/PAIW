<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\ShopPage;
use App\Livewire\ProductPage;
use App\Livewire\CartPage;

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
