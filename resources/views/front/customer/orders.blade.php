@extends('front.layout.page')

@section('front-content')
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-header d-flex justify-content-between align-items-center mb-4">
                    <h4 class="product-title d-block m-0">My Orders</h4>
                    <a href="{{ route('customer.profile') }}" class="w-fit border-btn py-2" style="min-height:auto">Back to
                        Profile</a>
                </div>
                <div class="card-border">

                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>#{{ $order->order_number }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
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
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.order.details', $order->id) }}"
                                                        class="w-fit border-btn py-2 place-order" style="min-height:auto">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="material-symbols-rounded text-muted" style="font-size: 64px;">receipt</i>
                                <h5 class="mt-3 text-muted">No Orders Yet</h5>
                                <p class="text-muted">You haven't placed any orders yet.</p>
                                <a href="{{ url('/') }}" class="btn btn-primary">Start Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection