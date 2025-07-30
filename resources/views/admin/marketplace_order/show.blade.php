@extends('admin.layout.page')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3 rounded-top-4">
                    <div>
                        <h5 class="mb-0">Invoice</h5>
                        <small>Order #{{ $marketplace_order->order_number }}</small>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark me-2">Status: {{ ucfirst($marketplace_order->status) }}</span>
                        <span class="badge bg-light text-dark">Payment: {{ ucfirst($marketplace_order->payment_status) }}</span>
                    </div>
                </div>

                <div class="card-body px-5 py-4">
                    {{-- Billing & Customer Details --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted mb-2">Billed To</h6>
                            <div class="border rounded p-3 bg-light">
                                <p class="mb-1"><strong>Name:</strong> {{ $marketplace_order->billing_name }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ $marketplace_order->billing_phone }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $marketplace_order->billing_email }}</p>
                                <p class="mb-0"><strong>Address:</strong> {{ $marketplace_order->billing_address }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                            <h6 class="text-uppercase text-muted mb-2">Order Details</h6>
                            <div class="border rounded p-3 bg-light">
                                <p class="mb-1"><strong>Customer:</strong> {{ $marketplace_order->customer ? $marketplace_order->customer->name : '-' }}</p>
                                <p class="mb-1"><strong>Platform:</strong> {{ ucfirst($marketplace_order->platform) }}</p>
                                <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($marketplace_order->payment_method) }}</p>
                                <p class="mb-0"><strong>Order Total:</strong> ₹{{ number_format($marketplace_order->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <h6 class="text-uppercase mb-3 mt-4">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-4">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Variant</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($marketplace_order->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->inventory ? $item->inventory->name : $item->product_name }}</td>
                                    <td>{{ $item->variant ? $item->variant->id : '-' }}</td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Grand Total --}}
                    <div class="d-flex justify-content-end">
                        <div class="border p-3 rounded bg-light w-50">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Grand Total</span>
                                <span class="fw-bold">₹{{ number_format($marketplace_order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('admin.marketplace-order.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-1"></i> Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
