@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg first-section">

<div class="container my-5 ">
    <div class="row g-5">

        <!-- Product Images Section -->
        <div class="col-md-6">
            <div class="mb-3 border rounded overflow-hidden">
                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100" alt="{{ $product->name }}">
            </div>
            <div class="d-flex gap-2 flex-wrap">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="img-thumbnail"
                         style="width: 80px; height: 100px; object-fit: cover; cursor: pointer;"
                         onclick="document.getElementById('mainImage').src=this.src">
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-md-6">
            <h2 class="fw-bold mb-2">{{ $product->name }}</h2>
            <p class="text-muted mb-1">Category: {{ $product->category->name ?? 'N/A' }}</p>

            <div class="mb-3">
                <span class="fs-4 fw-bold text-dark">₹{{ $product->discount_price ?? $product->price }}</span>
                @if ($product->discount_price)
                    <span class="text-muted text-decoration-line-through ms-2">₹{{ $product->price }}</span>
                    <span class="badge bg-danger ms-2">₹{{ $product->price - $product->discount_price }} OFF</span>
                @endif
            </div>

            <!-- Size Options -->
            <!-- @if (!empty($product->sizes))
            <div class="mb-3">
                <p class="fw-bold mb-2">Size</p>
                <div class="d-flex gap-2">
                    @foreach (explode(',', $product->sizes) as $size)
                        <button class="btn btn-outline-dark btn-sm rounded-pill">{{ trim($size) }}</button>
                    @endforeach
                </div>
            </div>
            @endif -->

            <!-- Quantity Selector -->
            <div class="mb-4 d-flex align-items-center">
                <label for="quantity" class="me-2 fw-bold">Qty:</label>
                <div class="input-group" style="width: 100px;">
                    <button class="btn btn-outline-secondary" onclick="updateQty(-1)">-</button>
                    <input type="number" id="quantity" value="1" class="form-control text-center" min="1">
                    <button class="btn btn-outline-secondary" onclick="updateQty(1)">+</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <button class="btn btn-dark py-2 fw-semibold">Add to Cart</button>
                <button class="btn btn-outline-dark py-2 fw-semibold">Buy it Now</button>
            </div>

            <!-- Trust Badges -->
            <div class="mt-4 border-top pt-3">
                <div class="d-flex flex-wrap gap-3 text-muted">
                    <div><i class="fa fa-shield-alt me-1 text-dark"></i> Secure Checkout</div>
                    <div><i class="fa fa-truck me-1 text-dark"></i> Free Shipping</div>
                    <div><i class="fa fa-undo me-1 text-dark"></i> Easy Returns</div>
                    <div><i class="fa fa-headset me-1 text-dark"></i> 24/7 Support</div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
    function updateQty(change) {
        let qty = document.getElementById('quantity');
        let val = parseInt(qty.value);
        qty.value = Math.max(1, val + change);
    }
</script>
@endsection