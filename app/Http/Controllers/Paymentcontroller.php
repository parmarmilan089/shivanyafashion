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
        if ($request->filled('return_sub_order_ids')) {
            Order::whereIn('sub_order_id', explode(',', $request->return_sub_order_ids))
                ->update(['payment_status' => 2]);
        }

        return redirect()->route('admin.payment.index')->with('success', 'Payment added successfully.');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        $deliveredIds = json_decode($payment->delivered_sub_order_ids, true) ?? [];
        $returnIds = json_decode($payment->return_sub_order_ids, true) ?? [];

        $deliveredOrders = Order::with(['orderProducts.product'])
            ->whereIn('sub_order_id', $deliveredIds)
            ->get();

        $returnOrders = Order::with(['orderProducts.product'])
            ->whereIn('sub_order_id', $returnIds)
            ->get();

        $foundSubOrderIds = $deliveredOrders->pluck('sub_order_id')->toArray();
        $returnfoundSubOrderIds = $returnOrders->pluck('sub_order_id')->toArray();
        $missingSubOrderIds = array_diff($deliveredIds, $foundSubOrderIds);
        $returnmissingSubOrderIds = array_diff($returnIds, $returnfoundSubOrderIds);

        // Optional auto-mark as paid
        Order::whereIn('sub_order_id', $foundSubOrderIds)->update(['payment_status' => 1]);
        Order::whereIn('sub_order_id', $returnmissingSubOrderIds)->update(['payment_status' => 2]);

        return view('admin.payment.show', compact(
            'payment',
            'deliveredOrders',
            'returnOrders',
            'missingSubOrderIds'
        ));
    }



}
