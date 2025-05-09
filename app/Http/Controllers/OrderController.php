<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function createOrder()
    {
        $products = Product::all();
        return view('admin.orders.create', compact('products'));
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'sold_on' => 'required|in:Amazon,Meesho',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.subtotal' => 'required|numeric|min:0',
        ]);


        DB::beginTransaction();
        try {

            // Create the order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'sold_on' => $validated['sold_on'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => $validated['total_amount'],
            ]);

            foreach ($validated['products'] as $product) {
                $order->product()->attach($product['product_id'], [ // ✅ Correct key
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'subtotal' => $product['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.order')->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    public function showOrder($id)
    {
        $order = Order::with('product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);

        // Deleting the order will also delete related records in `order_products`
        // because of the foreign key constraint with `onDelete('cascade')`.
        $order->delete();

        return redirect()->route('admin.order')
            ->with('success', 'Order deleted successfully.');
    }
}
