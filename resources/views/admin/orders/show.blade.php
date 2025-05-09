@extends('admin.layout.page')
@section('contect')

    <div class="container-fluid py-4">
        <h3 class="text-dark mb-3">Order Details - #{{ $order->order_number }}</h3>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Platform:</strong> {{ $order->sold_on }}</p>
                <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</p>
                <p><strong>Status:</strong> <span class="badge bg-info">{{ $order->order_status }}</span></p>
                <p><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <h5 class="mb-3">Products in this Order</h5>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->product as $product)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
                                            style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; vertical-align: middle;">
                                        <span>{{ $product->name }}</span>
                                    </td>
                                    <td>{{ $product->platform_sku }}</td>
                                    <td>₹{{ number_format($product->pivot->price, 2) }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>₹{{ number_format($product->pivot->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            @if($order->product->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No products found in this order.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.order') }}" class="btn btn-secondary mt-4">Back to Orders</a>
    </div>

@endsection