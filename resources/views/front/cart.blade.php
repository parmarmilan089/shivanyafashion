@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg first-section">
    <div class="container-fluid my-5">
        @php $cart = session('cart', []); $cart_total = 0; @endphp
        @if(count($cart))
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-10">
                    <h2 class="mb-4">Your Cart</h2>
                    <div class="p-4 border-0 rounded-4 cart-main-box" style="background:#f6f9f1;">
                        <h4 class="mb-4">Cart Items</h4>
                        @foreach($cart as $item)
                            @php $cart_total += $item['price'] * $item['quantity']; @endphp
                            <div class="d-flex flex-row align-items-center mb-3 pb-3 border-bottom cart-item-box" data-variant-id="{{ $item['variant_id'] }}" id="cart-item-{{ $item['variant_id'] }}">
                                <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" class="rounded-3 border" style="width:90px;height:90px;object-fit:cover;">
                                <div class="ms-4 flex-grow-1">
                                    <div class="product-title fw-bold fs-5 mb-1">{{ $item['product_name'] }}</div>
                                    <div class="text-muted mb-2">Color: <span class="fw-semibold">{{ $item['color_name'] }}</span></div>
                                    <div class="text-muted mb-2">Size: <span class="fw-semibold">{{ $item['size_name'] }}</span></div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <button class="btn btn-outline-dark btn-sm  px-2 py-1 fs-5 d-flex align-items-center justify-content-center" onclick="updateCartQty({{ $item['variant_id'] }}, {{ $item['quantity'] - 1 }})" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} style="width:32px;height:32px;">-</button>
                                        <input class="mb-3" type="text" value="{{ $item['quantity'] }}" style="width:40px;text-align:center;font-weight:600;font-size:16px;border:1px solid #ddd;border-radius:6px;" readonly id="qty-{{ $item['variant_id'] }}">
                                        <button class="btn btn-outline-dark btn-sm  px-2 py-1 fs-5 d-flex align-items-center justify-content-center" onclick="updateCartQty({{ $item['variant_id'] }}, {{ $item['quantity'] + 1 }})" style="width:32px;height:32px;">+</button>
                                    </div>
                                    <div class="fw-semibold">₹{{ $item['price'] }} x <span id="qty-label-{{ $item['variant_id'] }}">{{ $item['quantity'] }}</span></div>
                                </div>
                                <button class="btn btn-sm ms-3 rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;" onclick="removeCartItem({{ $item['variant_id'] }})">
                                    <i class="material-symbols-rounded" style="font-size:20px;">delete</i>
                                </button>
                            </div>
                        @endforeach
                        {{--  <div class="d-flex justify-content-between align-items-center pt-3">
                            <h5 class="mb-0">Cart Total: <span class="fw-bold">₹{{ $cart_total }}</span></h5>
                            <a href="{{ route('checkout.page') }}" class="btn btn-dark px-4 py-2 rounded-3">Proceed to Checkout</a>
                        </div>  --}}
                        <div class="cart__footer mt-4 d-flex justify-content-between align-items-center">
                            <div class="cart__note field mb-3">
                                <div>
                                    <div>
                                        <span class="note-area">
                                            <!-- SVG icon here, or use a Bootstrap icon if you prefer -->
                                            <svg id="Component_60_1" data-name="Component 60 – 1" xmlns="http://www.w3.org/2000/svg" width="23.159" height="21.5" viewBox="0 0 23.159 21.5" class="icon icon-free-shipping">
                                                <path id="Line_352" data-name="Line 352" d="M6.47.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H6.47A.75.75,0,0,1,7.22,0,.75.75,0,0,1,6.47.75Z" transform="translate(7.496 5.637)" fill="current-color"></path>
                                                <path id="Path_54601" data-name="Path 54601" d="M19.659,25.363H5.678a1.817,1.817,0,0,1-1.815-1.815V5.678A1.817,1.817,0,0,1,5.678,3.863H19.544a1.817,1.817,0,0,1,1.815,1.815V10.84a.75.75,0,0,1-1.5,0V5.678a.315.315,0,0,0-.315-.315H5.678a.316.316,0,0,0-.315.315v17.87a.315.315,0,0,0,.315.315H19.659a.315.315,0,0,0,.315-.315V20.936a.75.75,0,0,1,1.5,0v2.612A1.817,1.817,0,0,1,19.659,25.363Z" transform="translate(-3.863 -3.863)" fill="current-color"></path>
                                                <path id="Path_54602" data-name="Path 54602" d="M186.027,111.452h0a1.15,1.15,0,0,1-1.062-1.582l1.485-3.653a.75.75,0,0,1,.164-.248l6.21-6.215a2.1,2.1,0,0,1,2.965,0l.784.784a2.1,2.1,0,0,1,0,2.965l-6.21,6.215a.75.75,0,0,1-.248.165l-3.653,1.485A1.149,1.149,0,0,1,186.027,111.452Zm1.755-4.531-1.114,2.742,2.742-1.114,6.1-6.108a.6.6,0,0,0,0-.844l-.784-.784a.6.6,0,0,0-.844,0Z" transform="translate(-174.027 -93.427)" fill="current-color"></path>
                                                <path id="Line_353" data-name="Line 353" d="M2.688,3.438a.748.748,0,0,1-.53-.22L-.53.53A.75.75,0,0,1-.53-.53.75.75,0,0,1,.53-.53L3.219,2.158a.75.75,0,0,1-.53,1.28Z" transform="translate(18.539 7.649)" fill="current-color"></path>
                                                <path id="Path_54603" data-name="Path 54603" d="M213.588,213.576a.748.748,0,0,1-.53-.22l-2.688-2.688a.75.75,0,0,1,1.061-1.061l2.688,2.688a.75.75,0,0,1-.53,1.28Z" transform="translate(-197.783 -197.067)" fill="current-color"></path>
                                                <path id="Line_354" data-name="Line 354" d="M0,3.931a.748.748,0,0,1-.53-.22.75.75,0,0,1,0-1.061L2.651-.53a.75.75,0,0,1,1.061,0,.75.75,0,0,1,0,1.061L.53,3.711A.748.748,0,0,1,0,3.931Z" transform="translate(15.567 10.13)" fill="current-color"></path>
                                                <path id="Path_54604" data-name="Path 54604" d="M47.82,71.078a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,1,1,1.14-.974l.354.415.958-1.28a.75.75,0,0,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -63.729)" fill="current-color"></path>
                                                <path id="Line_355" data-name="Line 355" d="M5.126.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H5.126a.75.75,0,0,1,.75.75A.75.75,0,0,1,5.126.75Z" transform="translate(7.496 10.734)" fill="current-color"></path>
                                                <path id="Path_54605" data-name="Path 54605" d="M47.82,156.094a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,0,1,1.14-.974l.354.415.958-1.28a.75.75,0,1,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -143.648)" fill="current-color"></path>
                                                <path id="Line_356" data-name="Line 356" d="M2.427.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H2.427a.75.75,0,0,1,.75.75A.75.75,0,0,1,2.427.75Z" transform="translate(7.496 15.831)" fill="current-color"></path>
                                                <path id="Path_54606" data-name="Path 54606" d="M47.82,241.109a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,1,1,1.141-.974l.354.415.958-1.28a.75.75,0,1,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -223.567)" fill="current-color"></path>
                                            </svg>
                                            Add note
                                        </span>
                                    </div>
                                    <textarea class="text-area field__input form-control mt-2" name="note" id="Cart-note" placeholder="Enter the text here..."></textarea>
                                </div>
                            </div>
                            <div class="cart__blocks">
                                <div class="js-contents">
                                    <div class="totals mb-2">
                                        <h2 class="totals__subtotal h6 mb-0">Subtotal:</h2>
                                        <p class="totals__subtotal-value fw-bold mb-0">₹{{ $cart_total }}</p>
                                    </div>
                                    <small class="tax-note caption-large rte text-muted">Taxes and shipping calculated at checkout</small>
                                </div>
                                <div class="cart__ctas mt-3">
                                    <a href="{{ route('checkout.page') }}" class="cart__checkout-button btn btn-dark px-4 py-2 rounded-3 w-100" name="checkout">
                                        Check out
                                    </a>
                                </div>
                                <div id="cart-errors" class="mt-2"></div>
                                {{--  <form method="post" action="/cart" class="discount mt-3 d-flex gap-2">
                                    @csrf
                                    <input type="text" name="discount" placeholder="Discount code..." class="discount-code field__input form-control" required>
                                    <button id="apply-coupon" class="btn btn-primary" type="submit">Apply</button>
                                </form>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">Your cart is empty.</div>
        @endif
    </div>
</main>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function updateCartQty(variantId, newQty) {
    if (newQty < 1) return;
    axios.post('/cart/update', {
        cart_key: String(variantId),
        quantity: newQty,
        _token: '{{ csrf_token() }}'
    })
    .then(function(response) {
        // Optionally update the quantity in the UI
        document.getElementById('qty-' + variantId).value = newQty;
        document.getElementById('qty-label-' + variantId).textContent = newQty;
        // Optionally reload the page or update totals
        location.reload();
    })
    .catch(function(error) {
        alert('Failed to update cart.');
    });
}

function removeCartItem(variantId) {
    axios.post('/cart/remove', {
        cart_key: String(variantId),
        _token: '{{ csrf_token() }}'
    })
    .then(function(response) {
        // Remove the item from the DOM
        var item = document.getElementById('cart-item-' + variantId);
        if (item) item.remove();
        // Optionally reload the page or update totals
        location.reload();
    })
    .catch(function(error) {
        alert('Failed to remove item.');
    });
}
</script>
@endsection

@section('style')
<style>
.cart-main-box {
    margin-top: 30px;
    margin-bottom: 30px;
}
.cart-item-box {
    transition: box-shadow 0.2s;
    background: none !important;
    border-bottom: 1px solid #f0f0f0;
}
.cart-item-box:last-child {
    border-bottom: none;
}
.cart-item-box:hover {
    box-shadow: none;
    border-color: #e0e0e0;
}
.btn-outline-dark:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endsection
