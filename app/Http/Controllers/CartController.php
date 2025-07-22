<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\MarketplaceOrder;
use App\Models\MarketplaceOrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function checkout(Request $request)
    {
        // 1. Validate input
        $request->validate([
            // Billing
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address_line1' => 'required|string|max:255',
            'billing_address_line2' => 'required|string|max:255',
            'billing_state' => 'required|string|max:100',
            'billing_city' => 'required|string|max:100',
            'billing_pincode' => 'required|string|max:10',

            // Shipping
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_alt_phone' => 'nullable|string|max:20',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'shipping_pincode' => 'required|string|max:10',
            'shipping_country' => 'required|string|max:100',
            'shipping_address_type' => 'required|string|in:Home,Work,Other',
        ]);

        // 2. Assume you have cart items (from session or database)
        $cartItems = session()->get('cart', []); // or wherever your cart is stored
        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // 3. Calculate total
        $totalAmount = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // 4. Create full address string
        $fullAddress = implode(', ', [
            $request->billing_address_line1,
            $request->billing_address_line2,
            $request->billing_city,
            $request->billing_state,
            $request->billing_pincode
        ]);

        DB::beginTransaction();

        try {
            // 5. Store order
            $order = MarketplaceOrder::create([
                'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                'customer_id'      => auth('customer')->check() ? auth('customer')->id() : null,
                'billing_name'     => $request->billing_name,
                'billing_phone'    => $request->billing_phone,
                'billing_email'    => $request->billing_email,
                'billing_address'  => $fullAddress,
                'status'           => 'pending',
                'total_amount'     => $totalAmount,
                'payment_method'   => 'COD',
                'payment_status'   => 'unpaid',
            ]);

            // 6. Store order items
            foreach ($cartItems as $item) {
                MarketplaceOrderItem::create([
                    'marketplace_order_id' => $order->id,
                    'product_id'           => $item['inventory_id'],
                    'variant_id'           => $item['variant_id'] ?? null,
                    'product_name'         => $item['product_name'],
                    'price'                => $item['price'],
                    'qty'                  => $item['quantity'],
                    'subtotal'             => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // 7. Clear cart
            session()->forget('cart');

            return redirect()->route('order.success')->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

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
