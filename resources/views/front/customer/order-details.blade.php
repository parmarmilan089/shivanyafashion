@extends('front.layout.page')

@section('front-content')
    <div class="container py-5" style=" min-height: 80vh;">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10 col-md-10">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">Order Details</h3>
                    <a href="{{ route('customer.orders') }}" class="w-fit border-btn py-2" style="min-height:auto">Back to
                        Orders</a>
                </div>
                <div class="card-border main-order-card">

                    <div class="order-summary  p-sm-4 p-3 mb-4">
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Order Number</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2 ">#{{ $order->order_number }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Order Date</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Status</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'confirmed' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Total Amount</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">₹{{ number_format($order->total_amount, 2) }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Payment Method</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ strtoupper($order->payment_method) }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Payment Status</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ ucfirst($order->payment_status) }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Billing Name</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ $order->billing_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Billing Phone</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ $order->billing_phone }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Billing Email</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ $order->billing_email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6 order-title"><span>Billing Address</span>:</div>
                            <div class="col-sm-6 order-content mt-sm-0 mt-2">{{ $order->billing_address }}</div>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-3">Order Items</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle order-items-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Seller</th>
                                    <th>SKU</th>
                                    <th>Platform</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            @if($item->inventory)
                                                <span class="fw-semibold">{{ $item->inventory->name }}</span>
                                            @else
                                                {{ $item->product_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->inventory && $item->inventory->main_image)
                                                <img src="{{ asset('storage/' . $item->inventory->main_image) }}"
                                                    alt="Product Image"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                        <td>{{ $item->inventory->manufacturer ?? '-' }}</td>
                                        <td>{{ $item->inventory->sku ?? '-' }}</td>
                                        <td>{{ $item->inventory->selling_platform ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection