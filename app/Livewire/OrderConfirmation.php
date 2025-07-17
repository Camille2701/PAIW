<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderConfirmation extends Component
{
    public Order $order;

    public function mount($orderId)
    {
        $this->order = Order::with(['orderItems.productVariant.product', 'orderItems.productVariant.size', 'orderItems.productVariant.color'])
            ->findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.order-confirmation')
            ->layout('layouts.app');
    }
}
