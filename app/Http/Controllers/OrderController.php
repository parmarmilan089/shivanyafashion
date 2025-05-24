<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product');

        if ($request->filled('platform')) {
            $query->where('sold_on', $request->platform);
        }
        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $request->to_date);
        }

        $orders = $query->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function export(Request $request)
    {
        $filename = "orders_{$request->from_date}_to_{$request->to_date}.xlsx";
        return Excel::download(new OrdersExport($request->from_date, $request->to_date), $filename);
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
            'sub_order_id' => 'required|unique:orders,sub_order_id',
            'shipping' => 'required',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.base_price' => 'required|numeric|min:0',
            'products.*.subtotal' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {

            // Create the order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'sold_on' => $validated['sold_on'],
                'sub_order_id' => $validated['sub_order_id'],
                'shipping' => $validated['shipping'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => $validated['total_amount'],
            ]);

            foreach ($validated['products'] as $product) {
                $order->product()->attach($product['product_id'], [ // ✅ Correct key
                    'price' => $product['price'],
                    'base_price' => $product['base_price'],
                    'gst_price' => round($product['base_price'] * 1.05, 2),
                    'quantity' => $product['quantity'],
                    'subtotal' => $product['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.order.create')->with('success', 'Order placed successfully.');

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

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:Pending,Shipped,Delivered,Returned',
        ]);

        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }
}
