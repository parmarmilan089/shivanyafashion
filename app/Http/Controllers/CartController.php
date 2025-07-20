<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Retrieve existing cart from session
        $cart = session()->get('cart', []);
        $variantId = $request->variant_id;
        $requestedQty = $request->quantity;

        // Get the product variant to check stock
        $variant = ProductVariant::find($variantId);
        if (!$variant) {
            return response()->json(['error' => 'Variant not found'], 404);
        }

        // Check if enough stock is available
        if ($variant->stock_qty < $requestedQty) {
            return response()->json(['error' => 'Only ' . $variant->stock . ' item(s) left in stock'], 400);
        }
        // If product is already in cart, update quantity
        if (isset($cart[$variantId])) {
            $newQty = $cart[$variantId]['quantity'] + $requestedQty;

            // Check again if stock allows this new quantity
            if ($newQty > $variant->stock) {
                return response()->json(['error' => 'Only ' . $variant->stock . ' item(s) available'], 400);
            }

            $cart[$variantId]['quantity'] = $newQty;
        } else {
            // Add new item to cart
            $cartdata = [
                'variant_id'   => $variantId,
                'inventory_id' => $request->inventory_id,
                'product_name' => $request->product_name,
                'color_id'     => $request->color_id,
                'color_name'   => $request->color_name,
                'size_id'      => $request->size_id,
                'size_name'    => $request->size_name,
                'price'        => $request->price,
                'quantity'     => $requestedQty,
                'image'        => $request->image,
            ];

            $cart[$variantId] = $cartdata;
        }

        // Store updated cart
        session()->put('cart', $cart);

        return response()->json(['success' => 'Product added to cart']);
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

    // public function removeFromCart(Request $request)
    // {
    //     $request->validate([
    //         'cart_key' => 'required|string',
    //     ]);

    //     $cart = session()->get('cart', []);

    //     if (isset($cart[$request->cart_key])) {
    //         unset($cart[$request->cart_key]);
    //         session()->put('cart', $cart);
    //         session()->put('cart_count', count($cart));

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Item removed from cart',
    //             'cart_count' => count($cart),
    //             'cart_total' => $this->calculateCartTotal($cart)
    //         ]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    // }

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

    // public function clearCart()
    // {
    //     session()->forget('cart');
    //     session()->forget('cart_count');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Cart cleared'
    //     ]);
    // }

    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
