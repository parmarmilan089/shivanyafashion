@extends('admin.layout.page')

@section('contect')
<div class="container-fluid py-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Invoice</h5>
                    <a href="{{ route('admin.payment.index') }}" class="btn btn-sm btn-light text-dark">← Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6>Payment Details</h6>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->payment_received_date)->format('d M Y') }}</p>
                            <p><strong>Amount:</strong> ₹{{ number_format($payment->amount, 2) }}</p>
                            <p><strong>Description:</strong> {{ $payment->description ?? '—' }}</p>
                        </div>

                        <div class="col-md-6">
                            <h6>Sub Order IDs</h6>
                            <p><strong>Delivered:</strong><br>
                                @foreach(json_decode($payment->delivered_sub_order_ids, true) ?? [] as $id)
                                    <span class="badge bg-success me-1 mb-1">{{ $id }}</span>
                                @endforeach
                            </p>
                            <p><strong>Returned:</strong><br>
                                @foreach(json_decode($payment->return_sub_order_ids, true) ?? [] as $id)
                                    <span class="badge bg-danger me-1 mb-1">{{ $id }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delivered Orders and Products --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">Delivered Orders - Product Breakdown</h6>
                </div>
                <div class="card-body p-0">
                    @forelse($orders as $order)
                        <div class="table-responsive p-4 border-bottom">
                            <h6 class="text-dark mb-3">Sub Order ID: <span class="text-primary">{{ $order->sub_order_id }}</span></h6>
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Price (₹)</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; $subTotal = 0; @endphp
                                    @foreach($order->orderProducts as $op)
                                        @if($op->product)
                                            @php
                                                $total = $op->product->price * $op->quantity;
                                                $subTotal += $total;
                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/' . $op->product->image) }}" alt="Product Image"
                                                            style="width: 50px; height: 50px; object-fit: cover;" class="me-2 rounded">
                                                        <span>{{ $op->product->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $op->product->platform_sku }}</td>
                                                <td>{{ $op->size ?? 'N/A' }}</td>
                                                <td>{{ $op->quantity }}</td>
                                                <td>{{ number_format($op->product->price, 2) }}</td>
                                                <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-end"><strong>Sub Total</strong></td>
                                        <td><strong>₹{{ number_format($subTotal, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="p-4">
                            <p class="text-muted mb-0">No delivered orders found for this payment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection