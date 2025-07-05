@extends('admin.layout.page')
@section('content')

    <div class="container-fluid py-4">
        <div class="card shadow border">
            <div class="card-body px-4 py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-dark mb-0">Invoice #{{ $order->order_number }}</h4>
                    <span class="badge bg-primary fs-6">{{ $order->sold_on }}</span>
                </div>

                {{-- Status and Order Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}
                        </p>
                        <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p><strong>Payment Status:</strong>
                            <span
                                class="badge bg-{{ $order->payment_status == 1 ? 'success' : ($order->payment_status == 2 ? 'danger' : 'warning') }}">
                                @if($order->payment_status == 1)
                                    Received
                                @elseif($order->payment_status == 2)
                                    Cancel
                                @else
                                    Pending
                                @endif
                            </span>
                        </p>
                        @if($payment)
                            <a href="{{ route('admin.payment.show', $payment->id) }}"
                                class="btn btn-outline-primary btn-sm mb-3">
                                View Payment for Sub Order
                            </a>
                        @endif
                        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('PATCH')
                            <label for="order_status" class="fw-bold me-2">Order Status:</label>
                            <select name="order_status" onchange="this.form.submit()"
                                class="form-select d-inline-block w-auto form-select-sm">
                                <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>Shipped
                                </option>
                                <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                                <option value="Returned" {{ $order->order_status == 'Returned' ? 'selected' : '' }}>Returned
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                <h5 class="fw-bold border-bottom pb-2 mb-3">Products List</h5>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Sub Order ID</th>
                                <th>Shipping Partner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderProducts as $op)
                                @php $product = $op->product; @endphp
                                @if($product)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                                style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; vertical-align: middle;">
                                            <span>{{ $product->name }}</span>
                                        </td>
                                        <td>{{ $product->platform_sku }}</td>
                                        <td>₹{{ number_format($op->price, 2) }}</td>
                                        <td>{{ $op->quantity }}</td>
                                        <td>₹{{ number_format($op->subtotal, 2) }}</td>
                                        <td>{{ $order->sub_order_id ?? '-' }}</td>
                                        <td>{{ $order->shipping ?? '-' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($order->product->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No products found in this order.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.order') }}" class="btn btn-secondary">← Back to Orders</a>
                </div>
            </div>
        </div>
    </div>

@endsection