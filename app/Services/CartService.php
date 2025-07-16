<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCartItems()
    {
        if (Auth::check()) {
            // Utilisateur connecté - utiliser la base de données
            $cart = Cart::where('user_id', Auth::id())->first();
            return $cart ? $cart->items()->with(['productVariant.product', 'productVariant.color', 'productVariant.size'])->get() : collect();
        } else {
            // Utilisateur non connecté - utiliser la session
            $sessionCart = Session::get('cart', []);
            return collect($sessionCart)->map(function ($item, $variantId) {
                $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
                return (object) [
                    'id' => $variantId,
                    'product_variant_id' => $variantId,
                    'quantity' => $item['quantity'],
                    'productVariant' => $variant,
                ];
            });
        }
    }

    public function addToCart(int $productVariantId, int $quantity = 1)
    {
        $productVariant = ProductVariant::with(['product', 'color', 'size'])->findOrFail($productVariantId);

        if (Auth::check()) {
            // Utilisateur connecté
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $productVariantId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Utilisateur non connecté - utiliser la session
            $cart = Session::get('cart', []);

            if (isset($cart[$productVariantId])) {
                $cart[$productVariantId]['quantity'] += $quantity;
            } else {
                $cart[$productVariantId] = [
                    'product_variant_id' => $productVariantId,
                    'product_name' => $productVariant->product->name,
                    'color_name' => $productVariant->color->name,
                    'size_name' => $productVariant->size->label,
                    'price' => $productVariant->product->price,
                    'quantity' => $quantity,
                ];
            }

            Session::put('cart', $cart);
        }

        return true;
    }

    public function removeFromCart(int $productVariantId)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_variant_id', $productVariantId)
                    ->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$productVariantId]);
            Session::put('cart', $cart);
        }
    }

    public function updateQuantity(int $productVariantId, int $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($productVariantId);
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_variant_id', $productVariantId)
                    ->first();

                if ($cartItem) {
                    $cartItem->update(['quantity' => $quantity]);
                }
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productVariantId])) {
                $cart[$productVariantId]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }
        }
    }

    public function getTotalQuantity()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            return $cart ? $cart->total_quantity : 0;
        } else {
            $cart = Session::get('cart', []);
            return array_sum(array_column($cart, 'quantity'));
        }
    }

    public function getTotalPrice()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            return $cart ? $cart->total_price : 0;
        } else {
            $cart = Session::get('cart', []);
            return array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['price'];
            }, $cart));
        }
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->delete();
            }
        } else {
            Session::forget('cart');
        }
    }

    public function mergeSessionCartToDatabase()
    {
        if (Auth::check() && Session::has('cart')) {
            $sessionCart = Session::get('cart', []);
            $dbCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            foreach ($sessionCart as $variantId => $item) {
                $cartItem = CartItem::where('cart_id', $dbCart->id)
                    ->where('product_variant_id', $variantId)
                    ->first();

                if ($cartItem) {
                    $cartItem->increment('quantity', $item['quantity']);
                } else {
                    CartItem::create([
                        'cart_id' => $dbCart->id,
                        'product_variant_id' => $variantId,
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            Session::forget('cart');
        }
    }
}
