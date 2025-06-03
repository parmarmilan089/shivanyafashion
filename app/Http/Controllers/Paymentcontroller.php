<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class Paymentcontroller extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->get();
        return view('admin.payment.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.payment.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'payment_received_date' => 'required|date',
            'amount' => 'required|numeric',
            'return_sub_order_ids' => 'nullable|string',
            'delivered_sub_order_ids' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $paymentdata = [
            'payment_received_date' => $request->payment_received_date,
            'amount' => $request->amount,
            'delivered_sub_order_ids' => json_encode(array_map('trim', explode(',', $request->delivered_sub_order_ids))),
            'return_sub_order_ids' => json_encode(array_map('trim', explode(',', $request->return_sub_order_ids))),
            'description' => $request->description,
        ];
        Payment::create($paymentdata);

        // Update payment status in orders table
        if ($request->filled('delivered_sub_order_ids')) {
            Order::whereIn('sub_order_id', explode(',', $request->delivered_sub_order_ids))
                ->update(['payment_status' => 1]);
        }

        return redirect()->route('admin.payment.index')->with('success', 'Payment added successfully.');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        // Decode delivered sub order IDs from JSON
        $deliveredSubOrderIds = json_decode($payment->delivered_sub_order_ids, true) ?? [];

        // Fetch orders with those sub_order_ids and eager load related products
        $orders = Order::with(['orderProducts.product'])
            ->whereIn('sub_order_id', $deliveredSubOrderIds)
            ->get();

        // Extract sub_order_ids found in DB
        $foundSubOrderIds = $orders->pluck('sub_order_id')->toArray();

        // Determine which IDs were not found
        $missingSubOrderIds = array_diff($deliveredSubOrderIds, $foundSubOrderIds);
        
        // Optionally update payment status only for found orders
        Order::whereIn('sub_order_id', $foundSubOrderIds)->update(['payment_status' => 1]);

        return view('admin.payment.show', compact('payment', 'orders', 'missingSubOrderIds'));
    }


}
