<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\ShopPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/shop', function() {
    return redirect('/shop/men');
})->name('shop');
Route::get('/shop/men', ShopPage::class)->name('shop.men');
Route::get('/shop/women', ShopPage::class)->name('shop.women');
