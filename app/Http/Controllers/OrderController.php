<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Récupérer les commandes de l'utilisateur quand le modèle Order sera prêt
        // $orders = $user->orders()->latest()->paginate(10);

        return view('profile.orders', [
            'user' => $user,
            // 'orders' => $orders
        ]);
    }
}
