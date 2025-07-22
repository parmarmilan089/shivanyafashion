@extends('admin.layout.page')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Marketplace Order Details</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th>Order Number</th>
                            <td>{{ $marketplace_order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $marketplace_order->customer ? $marketplace_order->customer->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $marketplace_order->status }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{ $marketplace_order->total_amount }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>{{ $marketplace_order->payment_status }}</td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>{{ $marketplace_order->payment_method }}</td>
                        </tr>
                        <tr>
                            <th>Billing Name</th>
                            <td>{{ $marketplace_order->billing_name }}</td>
                        </tr>
                        <tr>
                            <th>Billing Phone</th>
                            <td>{{ $marketplace_order->billing_phone }}</td>
                        </tr>
                        <tr>
                            <th>Billing Email</th>
                            <td>{{ $marketplace_order->billing_email }}</td>
                        </tr>
                        <tr>
                            <th>Billing Address</th>
                            <td>{{ $marketplace_order->billing_address }}</td>
                        </tr>
                        <tr>
                            <th>Platform</th>
                            <td>{{ $marketplace_order->platform }}</td>
                        </tr>
                    </table>
                    <h6>Order Items</h6>
                    <table class="table table-bordered">
                        <thead>
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
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->subtotal }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.marketplace-order.index') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
