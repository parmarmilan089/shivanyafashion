<?php

namespace App\Http\Controllers;

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

        return redirect()->route('payment.index')->with('success', 'Payment added successfully.');
    }
}
