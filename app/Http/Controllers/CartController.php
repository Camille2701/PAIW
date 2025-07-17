<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        $totalPrice = $this->cartService->getTotalPrice();
        $totalQuantity = $this->cartService->getTotalQuantity();

        return view('cart.index', compact('cartItems', 'totalPrice', 'totalQuantity'));
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->addToCart(
            $request->product_variant_id,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cart_count' => $this->cartService->getTotalQuantity(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity(
            $request->product_variant_id,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartService->getTotalQuantity(),
            'cart_total' => $this->cartService->getTotalPrice(),
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
        ]);

        $this->cartService->removeFromCart($request->product_variant_id);

        return response()->json([
            'success' => true,
            'message' => 'Produit supprimé du panier',
            'cart_count' => $this->cartService->getTotalQuantity(),
            'cart_total' => $this->cartService->getTotalPrice(),
        ]);
    }

    public function getCount(): JsonResponse
    {
        return response()->json([
            'count' => $this->cartService->getTotalQuantity(),
        ]);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clearCart();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé',
        ]);
    }
}
