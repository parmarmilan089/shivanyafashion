@extends('front.layout.page')

@section('front-content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Order Invoice</h2>
                <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">← Back to Orders</a>
            </div>

            <div class="card shadow-sm p-4">
                <!-- Order Info -->
                <div class="mb-4">
                    <h5 class="mb-3 border-bottom pb-2 fw-semibold">Order Information</h5>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Order Number:</strong> #{{ $order->order_number }}</div>
                        <div class="col-sm-6"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <strong>Status:</strong>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'confirmed' => 'info',
                                    'shipped' => 'primary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="col-sm-6"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</div>
                        <div class="col-sm-6"><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</div>
                    </div>
                </div>

                <!-- Billing Info -->
                <div class="mb-4">
                    <h5 class="mb-3 border-bottom pb-2 fw-semibold">Billing Information</h5>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Name:</strong> {{ $order->billing_name }}</div>
                        <div class="col-sm-6"><strong>Phone:</strong> {{ $order->billing_phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"><strong>Email:</strong> {{ $order->billing_email }}</div>
                        <div class="col-sm-6"><strong>Address:</strong> {{ $order->billing_address }}</div>
                    </div>
                </div>

                <!-- Order Items -->
                <h5 class="mb-3 border-bottom pb-2 fw-semibold">Order Items</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle text-center">
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
                                    <strong>
                                        {{ $item->inventory->name ?? $item->product_name }}
                                    </strong>
                                </td>
                                <td>
                                    @if($item->inventory && $item->inventory->main_image)
                                        <img src="{{ asset('storage/' . $item->inventory->main_image) }}"
                                             alt="Product Image"
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    @elseif($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
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

                <!-- Grand Total -->
                <div class="d-flex justify-content-end">
                    <div class="text-end">
                        <h5 class="fw-bold">Total: ₹{{ number_format($order->total_amount, 2) }}</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Optional Styling -->
<style>
    .card {
        border-radius: 12px;
        border: none;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table img {
        border: 1px solid #e1e1e1;
        padding: 3px;
        background-color: #fff;
    }

    .btn-outline-secondary {
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
    }

    @media (max-width: 576px) {
        .table th, .table td {
            font-size: 13px;
        }

        .table img {
            width: 45px !important;
            height: 45px !important;
        }

        h2, h5 {
            font-size: 1.25rem;
        }
    }
</style>
@endsection
