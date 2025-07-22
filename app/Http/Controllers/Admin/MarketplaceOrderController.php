<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceOrder;
use Illuminate\Http\Request;

class MarketplaceOrderController extends Controller
{
    public function index()
    {
        $orders = MarketplaceOrder::with('customer')->latest()->get();
        return view('admin.marketplace_order.index', compact('orders'));
    }

    public function show(MarketplaceOrder $marketplace_order)
    {
        $marketplace_order->load(['customer', 'items.inventory', 'items.variant']);
        return view('admin.marketplace_order.show', compact('marketplace_order'));
    }
}
