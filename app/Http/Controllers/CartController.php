<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $inventory = Inventory::with(['variants.color', 'variants.size'])->find($request->inventory_id);
        $variant = $inventory->variants->where('id', $request->variant_id)->first();

        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Variant not found']);
        }

        $cartKey = $request->inventory_id . '_' . $request->variant_id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'inventory_id' => $request->inventory_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'name' => $inventory->name,
                'price' => $variant->price,
                'image' => $inventory->image,
                'color' => $variant->color->name ?? '',
                'size' => $variant->size->name ?? '',
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($cart)
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            $cart[$request->cart_key]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'cart_total' => $this->calculateCartTotal($cart)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cart_key])) {
            unset($cart[$request->cart_key]);
            session()->put('cart', $cart);
            session()->put('cart_count', count($cart));

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => count($cart),
                'cart_total' => $this->calculateCartTotal($cart)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        $cartTotal = $this->calculateCartTotal($cart);

        return response()->json([
            'cart' => $cart,
            'cart_count' => count($cart),
            'cart_total' => $cartTotal
        ]);
    }

    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('cart_count');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }

    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
