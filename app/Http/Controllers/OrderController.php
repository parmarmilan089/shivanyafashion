<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Exports\OrdersExport;
use App\Models\OrderProduct;
use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['product', 'orderProducts.product']);

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

        $orders = $query->orderBy('id', 'desc')->get();

        // Total Calculation
        $totalBasePrice = 0;
        $totalPrice = 0;

        foreach ($orders as $order) {
            foreach ($order->orderProducts as $op) {
                $totalBasePrice += $op->base_price;
                $totalPrice += $op->price;
            }
        }

        return view('admin.orders.index', compact('orders', 'totalBasePrice', 'totalPrice'));
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
                'description' => $request->description ?? '',
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
        $order = Order::with(['product', 'orderProducts.product'])->findOrFail($id);

        $payment = Payment::where(function ($query) use ($order) {
            $query->whereJsonContains('delivered_sub_order_ids', $order->sub_order_id)
                ->orWhereJsonContains('return_sub_order_ids', $order->sub_order_id);
        })->first();

        return view('admin.orders.show', compact('order', 'payment'));
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
        // Validate the selected order status
        $request->validate([
            'order_status' => 'required|in:Pending,Shipped,Delivered,Returned,RTO-Return,Wrong-RTO-Return,Wrong-Return,Missing-Return',
        ]);

        // Update the status
        $order->order_status = $request->order_status;

        // Define the statuses that require return charges
        $statusesWithCharges = ['Returned', 'Wrong-Return', 'Missing-Return'];

        // If the selected status is one that needs a return charge
        if (in_array($request->order_status, $statusesWithCharges)) {
            // Validate return shipping charge
            $request->validate([
                'return_shipping_charge' => 'required|numeric|min:0',
            ]);

            // Save the charge
            $order->return_charges = $request->return_shipping_charge;
        } else {
            // Clear any previous return charges if not required
            $order->return_charges = null;
        }

        $order->return_order_date = Carbon::today()->toDateString();
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatusForReturns()
    {
        $updated = Order::whereIn('order_status', ['Return', 'RTO-Return'])
            ->where('payment_status', 0)
            ->update(['payment_status' => 2]);

        return back()->with('success', "orders updated successfully.");
    }

    public function updateProductPrice($productId, $newPrice)
    {
        DB::transaction(function () use ($productId, $newPrice) {
            // Step 1: Update the price in the product table
            $product = Product::findOrFail($productId);
            $product->price = $newPrice;
            $product->save();

            // // Step 2: Update price in all related order_products
            OrderProduct::where('product_id', $productId)->update([
                'price' => $newPrice
            ]);

            // // Step 3: Recalculate order total_amounts
            $affectedOrderIds = OrderProduct::where('product_id', $productId)
                ->pluck('order_id')
                ->unique();
            foreach ($affectedOrderIds as $orderId) {
                $newTotal = OrderProduct::where('order_id', $orderId)
                    ->selectRaw('SUM(price * quantity) as total')
                    ->value('total');
                $orderProductdata = OrderProduct::where('order_id', $orderId)->first();
                $orderProductdata->subtotal = $newTotal;
                $orderProductdata->save();
                Order::where('id', $orderId)->update([
                    'total_amount' => $newTotal
                ]);
            }
        });
    }
}
