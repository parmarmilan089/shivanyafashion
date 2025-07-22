@extends('front.layout.page')

@section('front-content')
    <div class="container py-5" style="background: #f8fafc; min-height: 80vh;">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-7 col-md-9">
                <div class="card shadow-lg border-0 rounded-4 p-4" style="background: #fff;">
                    <div class="text-center">
                        <div class="d-flex justify-content-center mb-4">
                            <div style="background: #e6f9ed; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <span class="material-symbols-rounded text-success" style="font-size: 48px;">check_circle</span>
                            </div>
                        </div>
                        <h1 class="fw-bold text-success mb-2" style="font-size: 2.2rem;">Thank you for your order!</h1>
                        <p class="lead mb-3">Your order has been placed and is being processed.</p>
                        <p class="text-muted mb-4">A confirmation email with your order details has been sent to you.</p>
                    </div>

                    @if(session('order'))
                        @php $order = session('order'); @endphp
                        <div class="order-summary bg-light rounded-3 p-4 mb-4">
                            <h5 class="fw-semibold mb-3">Order Summary</h5>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Order Number:</div>
                                <div class="col-6 text-end fw-bold">#{{ $order->order_number ?? $order['order_number'] ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Total Amount:</div>
                                <div class="col-6 text-end fw-bold">₹{{ $order->total ?? $order['total'] ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Payment Status:</div>
                                <div class="col-6 text-end fw-bold">{{ $order->payment_status ?? $order['payment_status'] ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">Shipping Address:</div>
                                <div class="col-6 text-end">{{ $order->shipping_address ?? $order['shipping_address'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <span class="fw-semibold">Estimated Delivery:</span> <span class="text-success">3-7 business days</span>
                    </div>
                    <div class="mb-4">
                        <span class="fw-semibold">Need help?</span> <span class="text-muted">Contact our support at <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a> or WhatsApp <a href="https://wa.me/919979944324">+91 99799 44324</a>.</span>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                        <a href="/customer/orders" class="btn btn-outline-success px-4">View My Orders</a>
                        <a href="/" class="btn btn-primary px-4">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
