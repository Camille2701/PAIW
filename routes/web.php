<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\ShopPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/shop', ShopPage::class)->name('shop');
