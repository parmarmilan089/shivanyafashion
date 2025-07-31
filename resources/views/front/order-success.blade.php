@extends('front.layout.page')

@section('front-content')
<div class="container py-5" style="background: #f6f8fd; min-height: 85vh;">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 rounded-5 shadow p-4 py-5" style="background: #fff;">
                <div class="text-center">
                    <!-- Animated Check Mark -->
                    <div class="position-relative d-inline-block mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                            <span class="material-symbols-rounded text-success" style="font-size: 58px; animation: pop 0.7s cubic-bezier(0.18, 0.89, 0.32, 1.28);">
                                check_circle
                            </span>
                        </div>
                    </div>
                    <h1 class="fw-bold text-success my-3" style="font-size: 2.35rem;">Thank you for your order!</h1>
                    <p class="lead text-dark">We've received your order and are getting it ready for you.</p>
                    <p class="text-muted mb-4" style="font-size: 1.08rem;">A confirmation email and receipt have been sent to your inbox.</p>
                </div>

                <!-- Status Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center" style="font-size: 0.93rem;">
                        <div class="fw-bold text-success">Order Placed</div>
                        <div class="text-muted">Order Processing</div>
                        <div class="text-muted">Shipped</div>
                        <div class="text-muted">Delivered</div>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 25%"></div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                @if(session('order'))
                    @php $order = session('order'); @endphp
                    <div class="order-summary bg-light rounded-4 p-4 mb-4 shadow-sm text-dark">
                        <h5 class="fw-semibold mb-3" style="letter-spacing: 1px;">Order Summary</h5>
                        <div class="row mb-2">
                            <div class="col-7 text-muted">Order Number:</div>
                            <div class="col-5 text-end fw-bold text-dark">#{{ $order->order_number ?? $order['order_number'] ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-7 text-muted">Total Amount:</div>
                            <div class="col-5 text-end fw-bold text-primary">₹{{ $order->total ?? $order['total'] ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-7 text-muted">Payment Status:</div>
                            <div class="col-5 text-end fw-bold">
                                <span class="{{ (strtolower($order->payment_status ?? $order['payment_status'] ?? '') == 'paid') ? 'text-success' : 'text-warning' }}">
                                    {{ $order->payment_status ?? $order['payment_status'] ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-7 text-muted">Shipping Address:</div>
                            <div class="col-5 text-end fst-italic" style="max-width: 220px; word-break: break-word;">{{ $order->shipping_address ?? $order['shipping_address'] ?? 'N/A' }}</div>
                        </div>
                        {{-- More details can go here, like items, shipping method, etc. --}}
                    </div>
                @endif

                <!-- Estimated Delivery and Support -->
                <div class="bg-white border-start border-4 border-success rounded-4 p-3 mb-3 shadow-sm d-flex align-items-center">
                    <span class="material-symbols-rounded text-success me-2" style="font-size: 28px;">
                        local_shipping
                    </span>
                    <span>
                        <strong>Estimated Delivery:</strong> <span class="text-success">3 - 7 business days</span>
                    </span>
                </div>
                <div class="text-dark mb-4 d-flex align-items-center" style="font-size: 1.07rem;">
                    <span class="material-symbols-rounded text-primary me-2" style="font-size: 22px;">contact_support</span>
                    <span>
                        Need help? <span class="text-muted">Write to <a href="mailto:shivanyafs@gmail.com" class="text-primary">shivanyafs@gmail.com</a>
                            or WhatsApp <a href="https://wa.me/919979944324" class="text-success" target="_blank">+91 99799 44324</a></span>
                    </span>
                </div>

                <!-- Buttons -->
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="/customer/orders" class="btn btn-outline-success px-4 py-2 fw-semibold">
                        <span class="material-symbols-rounded align-middle me-1">receipt_long</span>
                        View Your Orders
                    </a>
                    <a href="/" class="btn btn-primary px-4 py-2 fw-semibold">
                        <span class="material-symbols-rounded align-middle me-1">shopping_bag</span>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Subtle keyframes for icon pop animation -->
<style>
@keyframes pop {    
    0% { transform: scale(0.7); opacity: 0.2; }
    80% { transform: scale(1.15); opacity: 0.9; }
    100% { transform: scale(1); opacity: 1; }
}
::-webkit-scrollbar { width: 8px; background: #f5f6fa; }
::-webkit-scrollbar-thumb { background: #ebecee; border-radius: 8px; }
</style>
@endsection
