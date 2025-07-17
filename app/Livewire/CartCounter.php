<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartCounter extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $cartService = app(CartService::class);
        $this->cartCount = $cartService->getTotalQuantity();
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
