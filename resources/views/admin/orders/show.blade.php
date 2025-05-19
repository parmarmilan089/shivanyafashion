@extends('admin.layout.page')
@section('contect')

    <div class="container-fluid py-4">
        <h3 class="text-dark mb-3">Order Details - #{{ $order->order_number }}</h3>

        {{-- Success message after status update --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Platform:</strong> {{ $order->sold_on }}</p>
                <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</p>

                {{-- Updated status dropdown form --}}
                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" class="w-100 d-flex align-items-center" style="max-width: 300px;">
                    @csrf
                    @method('PATCH')
                    <label for="order_status" class="me-2 fw-bold">Status:</label>
                    <select name="order_status" onchange="this.form.submit()" class="form-select form-select-sm">
                        <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Returned" {{ $order->order_status == 'Returned' ? 'selected' : '' }}>Returned</option>
                    </select>
                </form>

                <p class="mt-3"><strong>Total Amount:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
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
