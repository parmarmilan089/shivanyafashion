@extends('front.layout.page')

@section('front-content')
<div class="container py-5" style="background: #f8fafc; min-height: 80vh;">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold mb-0">Order Details</h3>
                    <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary btn-sm">Back to Orders</a>
                </div>
                <div class="order-summary bg-light rounded-3 p-4 mb-4">
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Order Number:</div>
                        <div class="col-6 text-end fw-bold">#{{ $order->order_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Order Date:</div>
                        <div class="col-6 text-end">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Status:</div>
                        <div class="col-6 text-end">
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
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Total Amount:</div>
                        <div class="col-6 text-end fw-bold">₹{{ number_format($order->total_amount, 2) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Payment Method:</div>
                        <div class="col-6 text-end">{{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Payment Status:</div>
                        <div class="col-6 text-end">{{ ucfirst($order->payment_status) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Billing Name:</div>
                        <div class="col-6 text-end">{{ $order->billing_name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Billing Phone:</div>
                        <div class="col-6 text-end">{{ $order->billing_phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Billing Email:</div>
                        <div class="col-6 text-end">{{ $order->billing_email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-muted">Billing Address:</div>
                        <div class="col-6 text-end">{{ $order->billing_address }}</div>
                    </div>
                </div>
                <h5 class="fw-semibold mb-3">Order Items</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
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
                                            <img src="{{ asset('storage/' . $item->inventory->main_image) }}" alt="Product Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
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
