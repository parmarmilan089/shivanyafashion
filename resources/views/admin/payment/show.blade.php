@extends('admin.layout.page')

@section('contect')
    <div class="container-fluid py-4">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Payment Invoice</h5>
                        <a href="{{ route('admin.payment.index') }}" class="btn btn-sm btn-light text-dark">← Back to
                            List</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6>Payment Details</h6>
                                <p><strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($payment->payment_received_date)->format('d M Y') }}</p>
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

                        @if(!empty($missingSubOrderIds))
                            <div class="alert alert-warning mt-4">
                                <strong>Missing Sub Order IDs:</strong><br>
                                <small>The following Delivered Sub Order IDs were not found in the orders table:</small>
                                <div class="mt-2">
                                    @foreach($missingSubOrderIds as $missingId)
                                        <span class="badge bg-warning text-dark me-1 mb-1">{{ $missingId }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Delivered Orders --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-gradient-primary text-white">
                        <h6 class="mb-0">Delivered Orders - Product Breakdown</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-2 border-bottom">
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
                                        <th>Payment</th>
                                        <th>Sub Order ID</th>
                                        <th>Purchase Date</th> {{-- ✅ New Column --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deliveredOrders as $key => $order)
                                        @foreach($order->orderProducts as $op)
                                            @if($op->product)
                                                @php $total = $op->product->price * $op->quantity; @endphp
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.product.edit', $op->product->id) }}">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('storage/' . $op->product->image) }}"
                                                                    alt="Product Image"
                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                    class="me-2 rounded">
                                                                <span>{{ Str::limit($op->product->name, 20) }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>{{ $op->product->platform_sku }}</td>
                                                    <td>{{ $op->size ?? 'N/A' }}</td>
                                                    <td>{{ $op->quantity }}</td>
                                                    <td>{{ number_format($op->product->price, 2) }}</td>
                                                    <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                                                    <td>
                                                        @if($order->payment_status == 1)
                                                            <span class="badge bg-success mt-2">Received</span>
                                                        @elseif($order->payment_status == 2)
                                                            <span class="badge bg-danger mt-2">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning mt-2">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->sub_order_id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</td> {{-- ✅
                                                    New --}}
                                                </tr>
                                            @endif
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No delivered orders found for this
                                                payment.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Returned Orders --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-gradient-danger text-white">
                        <h6 class="mb-0">Returned Orders - Product Breakdown</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-2 border-bottom">
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
                                        <th>Payment</th>
                                        <th>Sub Order ID</th>
                                        <th>Purchase Date</th> {{-- ✅ New Column --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($returnOrders as $key => $order)
                                        @foreach($order->orderProducts as $op)
                                            @if($op->product)
                                                @php $total = $op->product->price * $op->quantity; @endphp
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.product.edit', $op->product->id) }}">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('storage/' . $op->product->image) }}"
                                                                    alt="Product Image"
                                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                                    class="me-2 rounded">
                                                                <span>{{ Str::limit($op->product->name, 20) }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td>{{ $op->product->platform_sku }}</td>
                                                    <td>{{ $op->size ?? 'N/A' }}</td>
                                                    <td>{{ $op->quantity }}</td>
                                                    <td>{{ number_format($op->product->price, 2) }}</td>
                                                    <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                                                    <td>
                                                        @if($order->payment_status == 1)
                                                            <span class="badge bg-success mt-2">Received</span>
                                                        @elseif($order->payment_status == 2)
                                                            <span class="badge bg-danger mt-2">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning mt-2">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $order->sub_order_id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</td> {{-- ✅
                                                    New --}}
                                                </tr>
                                            @endif
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No returned orders found for this
                                                payment.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection