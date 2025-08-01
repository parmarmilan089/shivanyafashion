@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg first-section">

<div class="container my-5 ">
    <section class="product-details-section pt-100-ct">
		<div class="container-ct" id="product-options">
            <script>
                window.productOptionsProps = @json([
                    'variants' => $variantData,
                    'product' => $product,
                ]);
            </script>
            <product-options ></product-options>

		</div>
	</section>

    <!-- Related Products Section -->
    @if($relatedProducts->count() > 0)
    <section class="related-products-section pt-100-ct">
        <div class="container-ct">
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title text-center mb-5">Related Products</h3>
                </div>
            </div>

            <div class="related-products-slider">
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        @php
                            $minPrice = $relatedProduct->variants->min('price');
                            $firstVariant = $relatedProduct->variants->first();
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product-card h-100">
                                <div class="position-relative product-items-img">
                                    @php
                                        // Use first variant's gallery images if available, otherwise fall back to product's gallery
                                        $gallery = $firstVariant && $firstVariant->gallery_images ? $firstVariant->gallery_images : $relatedProduct->gallery_images;
                                        $hasGallery = is_array($gallery) && count($gallery) > 0;
                                    @endphp
                                    @if($hasGallery)
                                        <div id="carousel-related-{{ $relatedProduct->id }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($gallery as $idx => $img)
                                                    <div class="carousel-item{{ $idx === 0 ? ' active' : '' }}">
                                                        <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100 object-fit-cover" alt="{{ $relatedProduct->name }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($gallery) > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-related-{{ $relatedProduct->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-related-{{ $relatedProduct->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    @elseif($firstVariant && $firstVariant->main_image)
                                        <img src="{{ asset('storage/' . $firstVariant->main_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $relatedProduct->name }}">
                                    @elseif($relatedProduct->main_image)
                                        <img src="{{ asset('storage/' . $relatedProduct->main_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $relatedProduct->name }}">
                                    @endif

                                    <!-- Quick Add to Cart Button -->
                                    <div class="quick-add-overlay">
                                        <button class="quick-add-btn" onclick="quickAddToCart({{ $relatedProduct->id }}, {{ $firstVariant->id ?? 'null' }})">
                                            <i class="fas fa-shopping-cart"></i> Quick Add
                                        </button>
                                    </div>
                                </div>

                                <div class="product-info p-3">
                                    <h5 class="product-title mb-2">
                                        <a href="{{ route('product', $relatedProduct->id) }}" class="text-decoration-none text-dark">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h5>
                                    <div class="product-price mb-2">
                                        @if($firstVariant && $firstVariant->sale_price)
                                            <span class="current-price text-primary fw-bold">₹{{ number_format($firstVariant->sale_price) }}</span>
                                            <span class="original-price text-muted text-decoration-line-through ms-2">₹{{ number_format($firstVariant->price) }}</span>
                                        @else
                                            <span class="current-price text-primary fw-bold">₹{{ number_format($minPrice) }}</span>
                                        @endif
                                    </div>

                                    <!-- Product Attributes -->
                                    <div class="product-attributes small text-muted">
                                        @if($relatedProduct->fabric)
                                            <span class="attribute-item">{{ $relatedProduct->fabric }}</span>
                                        @endif
                                        @if($relatedProduct->pattern)
                                            <span class="attribute-item">{{ $relatedProduct->pattern }}</span>
                                        @endif
                                        @if($relatedProduct->fit)
                                            <span class="attribute-item">{{ $relatedProduct->fit }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
</main>

<!-- Related Products Styles -->
<style>
.related-products-section {
    background-color: #f6f9f1;
    padding: 60px 0;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 40px;
}

.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-items-img {
    height: 250px;
    overflow: hidden;
    position: relative;
}

.product-items-img img,
.product-items-img .carousel {
    height: 100%;
    width: 100%;
}

.carousel-control-prev,
.carousel-control-next {
    width: 30px;
    height: 30px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.carousel-control-prev {
    left: 10px;
}

.carousel-control-next {
    right: 10px;
}

.quick-add-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .quick-add-overlay {
    opacity: 1;
}

.quick-add-btn {
    background: #222121;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quick-add-btn:hover {
    background: #333;
    transform: scale(1.05);
}

.product-title {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.4;
    height: 2.8rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-title a:hover {
    color: #222121 !important;
}

.current-price {
    font-size: 1.1rem;
}

.original-price {
    font-size: 0.9rem;
}

.product-attributes {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.attribute-item {
    background: #f1f3f4;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .product-items-img {
        height: 200px;
    }

    .product-title {
        font-size: 0.9rem;
    }
}
</style>

<script>
function quickAddToCart(inventoryId, variantId) {
    if (!variantId) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a variant first'
        });
        return;
    }

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            inventory_id: inventoryId,
            variant_id: variantId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            const cartCountElement = document.getElementById('cartCount');
            if (cartCountElement) {
                cartCountElement.textContent = data.cart_count;
            }

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Item added to cart successfully!'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Error adding item to cart'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error adding item to cart'
        });
    });
}
</script>
@endsection
