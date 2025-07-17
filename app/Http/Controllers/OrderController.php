<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Récupérer les commandes de l'utilisateur avec les items et les relations
        $orders = Order::where('user_id', $user->id)
            ->with(['orderItems.productVariant.product', 'orderItems.productVariant.size', 'orderItems.productVariant.color'])
            ->latest()
            ->paginate(10);

        return view('profile.orders', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}
