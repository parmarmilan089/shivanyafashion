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
                            $variantsByColor = $relatedProduct->variants->groupBy('color_id');
                            $firstColorVariants = $variantsByColor->first();
                            $firstVariant = $firstColorVariants ? $firstColorVariants->first() : null;
                        @endphp
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                            <div class="product-card h-100" data-product-id="{{ $relatedProduct->id }}">
                                <div class="position-relative product-items-img">
                                    <!-- Product Image Container -->
                                    <div class="product-image-container" id="product-image-{{ $relatedProduct->id }}">
                                        @php
                                            $firstGallery = $firstVariant && $firstVariant->gallery_images ? $firstVariant->gallery_images : ($relatedProduct->gallery_images ?? []);
                                            $hasGallery = is_array($firstGallery) && count($firstGallery) > 0;
                                        @endphp

                                        @if($hasGallery)
                                            <div id="carousel-related-{{ $relatedProduct->id }}" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach($firstGallery as $idx => $img)
                                                        <div class="carousel-item{{ $idx === 0 ? ' active' : '' }}">
                                                            <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100 object-fit-cover" alt="{{ $relatedProduct->name }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if(count($firstGallery) > 1)
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
                                    </div>

                                    <!-- Quick Add to Cart Button -->
                                    <div class="quick-add-overlay">
                                        <button class="quick-add-btn" id="quick-add-btn-{{ $relatedProduct->id }}"
                                                onclick="quickAddToCart({{ $relatedProduct->id }}, {{ $firstVariant->id ?? 'null' }}, '{{ addslashes($relatedProduct->name) }}', {{ $firstVariant->color_id ?? 'null' }}, '{{ addslashes($firstVariant->color->name ?? '') }}', {{ $firstVariant->size_id ?? 'null' }}, '{{ addslashes($firstVariant->size->name ?? '') }}', {{ $firstVariant->sale_price ?? $firstVariant->price ?? $minPrice }}, '{{ $firstVariant->main_image ? asset('storage/' . $firstVariant->main_image) : ($relatedProduct->main_image ? asset('storage/' . $relatedProduct->main_image) : '') }}')">
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

                                    <!-- Color Selection -->
                                    @if($variantsByColor->count() > 1)
                                        <div class="color-selection mb-3">
                                            <label class="form-label small text-muted mb-2">Select Color:</label>
                                            <div class="color-options d-flex gap-2 flex-wrap">
                                                @foreach($variantsByColor as $colorId => $colorVariants)
                                                    @php
                                                        $colorVariant = $colorVariants->first();
                                                        $color = $colorVariant->color;
                                                        $isFirstColor = $loop->first;
                                                    @endphp
                                                    @php
                                                        $colorGallery = $colorVariant->gallery_images ? $colorVariant->gallery_images : ($relatedProduct->gallery_images ?? []);
                                                        $colorGalleryJson = json_encode($colorGallery);
                                                        $colorImage = $colorVariant->main_image ? asset('storage/' . $colorVariant->main_image) : ($relatedProduct->main_image ? asset('storage/' . $relatedProduct->main_image) : '');
                                                    @endphp
                                                    <button type="button"
                                                            class="color-option {{ $isFirstColor ? 'active' : '' }}"
                                                            data-product-id="{{ $relatedProduct->id }}"
                                                            data-color-id="{{ $colorId }}"
                                                            data-variant-id="{{ $colorVariant->id }}"
                                                            data-color-name="{{ $color->name ?? '' }}"
                                                            data-size-id="{{ $colorVariant->size_id }}"
                                                            data-size-name="{{ $colorVariant->size->name ?? '' }}"
                                                            data-price="{{ $colorVariant->sale_price ?? $colorVariant->price }}"
                                                            data-image="{{ $colorImage }}"
                                                            data-gallery="{{ $colorGalleryJson }}"
                                                            onclick="selectColor(this, {{ $relatedProduct->id }})"
                                                            title="{{ $color->name ?? 'Unknown Color' }}">
                                                        <span class="color-dot" style="background-color: {{ $color->code ?? '#ccc' }};"></span>
                                                        <span class="color-name">{{ $color->name ?? 'Unknown' }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="product-price mb-2">
                                        <span class="current-price text-primary fw-bold" id="price-{{ $relatedProduct->id }}">₹{{ number_format($firstVariant->sale_price ?? $firstVariant->price ?? $minPrice) }}</span>
                                        @if($firstVariant && $firstVariant->sale_price)
                                            <span class="original-price text-muted text-decoration-line-through ms-2">₹{{ number_format($firstVariant->price) }}</span>
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

/* Color Selection Styles */
.color-selection {
    margin-top: 10px;
}

.color-options {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.color-option {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 2px solid #e9ecef;
    border-radius: 20px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.8rem;
    min-width: fit-content;
}

.color-option:hover {
    border-color: #222121;
    transform: translateY(-1px);
}

.color-option.active {
    border-color: #222121;
    background: #f8f9fa;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.color-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.color-name {
    font-weight: 500;
    color: #333;
}

/* Product Image Container */
.product-image-container {
    height: 100%;
    width: 100%;
    overflow: hidden;
    position: relative;
}

.product-image-container img {
    transition: opacity 0.3s ease;
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

    .color-option {
        padding: 4px 8px;
        font-size: 0.75rem;
    }

    .color-dot {
        width: 12px;
        height: 12px;
    }
}
</style>

<script>
function quickAddToCart(inventoryId, variantId, productName, colorId, colorName, sizeId, sizeName, price, image) {
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
            product_name: productName,
            color_id: colorId,
            color_name: colorName,
            size_id: sizeId,
            size_name: sizeName,
            price: price,
            image: image,
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

function selectColor(colorButton, productId) {
    // Remove active class from all color options for this product
    const productCard = document.querySelector(`[data-product-id="${productId}"]`);
    const colorOptions = productCard.querySelectorAll('.color-option');
    colorOptions.forEach(option => option.classList.remove('active'));

    // Add active class to selected color option
    colorButton.classList.add('active');

    // Get data from the selected color button
    const variantId = colorButton.getAttribute('data-variant-id');
    const colorId = colorButton.getAttribute('data-color-id');
    const colorName = colorButton.getAttribute('data-color-name');
    const sizeId = colorButton.getAttribute('data-size-id');
    const sizeName = colorButton.getAttribute('data-size-name');
    const price = colorButton.getAttribute('data-price');
    const image = colorButton.getAttribute('data-image');
    const gallery = JSON.parse(colorButton.getAttribute('data-gallery') || '[]');

    // Update product image/gallery
    const imageContainer = document.getElementById(`product-image-${productId}`);
    if (imageContainer) {
        if (gallery && gallery.length > 0) {
            // Create carousel for gallery images
            let carouselHtml = `<div id="carousel-related-${productId}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">`;

            gallery.forEach((img, idx) => {
                carouselHtml += `<div class="carousel-item${idx === 0 ? ' active' : ''}">
                    <img src="/storage/${img}" class="w-100 h-100 object-fit-cover" alt="Product Image">
                </div>`;
            });

            carouselHtml += `</div>`;

            // Add navigation buttons if multiple images
            if (gallery.length > 1) {
                carouselHtml += `<button class="carousel-control-prev" type="button" data-bs-target="#carousel-related-${productId}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel-related-${productId}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>`;
            }

            carouselHtml += `</div>`;
            imageContainer.innerHTML = carouselHtml;
        } else if (image) {
            // Single image
            imageContainer.innerHTML = `<img src="${image}" class="w-100 h-100 object-fit-cover" alt="Product Image">`;
        }
    }

    // Update price
    const priceElement = document.getElementById(`price-${productId}`);
    if (priceElement) {
        priceElement.textContent = `₹${parseFloat(price).toLocaleString()}`;
    }

    // Update quick add button onclick
    const quickAddBtn = document.getElementById(`quick-add-btn-${productId}`);
    if (quickAddBtn) {
        const productName = quickAddBtn.getAttribute('onclick').match(/'([^']+)'/)[1];
        quickAddBtn.setAttribute('onclick', `quickAddToCart(${productId}, ${variantId}, '${productName}', ${colorId}, '${colorName}', ${sizeId}, '${sizeName}', ${price}, '${image}')`);
    }
}
</script>
@endsection
