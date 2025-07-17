<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\CartService;

class MergeSessionCart
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(Login $event): void
    {
        // Fusionner le panier de session avec le panier en base de données
        $this->cartService->mergeSessionCartToDatabase();
    }
}
