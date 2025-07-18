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

    public function cancel(Order $order)
    {
        // Vérifier que l'utilisateur peut annuler cette commande
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette commande.');
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Cette commande ne peut plus être annulée.');
        }

        if ($order->cancel()) {
            return back()->with('success', 'Commande annulée avec succès. Le stock a été remis à jour et vous recevrez un email de confirmation.');
        }

        return back()->with('error', 'Erreur lors de l\'annulation de la commande.');
    }
}
