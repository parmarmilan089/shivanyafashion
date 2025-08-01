@extends('front.layout.page')

@section('front-content')

	<!-- Hero Section -->
	<section class="hero-banner-section w-100">
		<div class="w-100">
			<div class="position-relative overflow-hidden banner-items" style="
																																																												background-image: url('{{ asset('assets/img/banner1.png') }}');
																																																												">
				<!-- Optional dark overlay -->
				<div class="position-absolute top-0 start-0 w-100 h-100 " style="opacity: 0.4;"></div>

				<!-- Text on top of image -->
				<div
					class="position-relative z-index-2 text-white h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
					<!-- <h1 class="display-4 text-dark font-weight-bold mt-5">Welcome to Shivanya Fashion</h1> -->
					<p class="lead text-white">
						<!-- Discover the latest ethnic wear, festival collections, and trending styles curated just for you. -->
					</p>
					<!-- <a href="{{ url('/store') }}" class="btn bg-gradient-dark mt-3">Shop Now</a> -->
				</div>

			</div>
		</div>
	</section>

	<!-- Categories Section -->
	<section class="categories-section pt-100-ct">
		<div class="container-ct">
			<h3 class="main-title">Featured Categories</h3>
			<div class="main-categories-card d-flex items-start gap-3 gap-lg-4	overflow-auto scroll-1">
				@foreach ($categorys as $category)
					<div class="categories-card overflow-hidden">
						<!-- Category Image -->
						<div class="categories-card-img w-90 overflow-hidden flex-1">
							<!-- <img src="{{ asset($category['image']) }}" alt="{{ $category['name'] }}" class="w-100 h-100 object-cover"> -->
							<img src="{{ asset($category['image']) }}"
								class="w-100 h-100 object-cover">
						</div>
						<!-- Category Name -->
						<div class="p-3">
							<h6 class="categories-name">{{ $category['name'] }}</h6>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Featured Products Slider -->
	<section class="w-100 container-fluid pt-140-ct featured-product-section px-xl-0">
		<div class="main-featured-product d-flex align-items-end gap-lg-7 gap-5">
			<div class="left-product-img-div d-md-block d-none">
				<img src="//dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=165 165w, //dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=360 360w, //dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=535 535w, //dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=750 750w, //dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=1070 1070w, //dt-vogue.myshopify.com/cdn/shop/files/Mask_group_12.png?v=1698384651&width=1500 1500w"
					alt="img" class="w-100 h-100 object-cover">
			</div>
			<div class="w-100 flex-1 right-product-fea overflow-hidden">
				<h3 class="main-title">Featured Products</h3>
				<div class="product-featured-items d-flex items-start gap-3 gap-lg-4 overflow-auto scroll-1">
					@foreach ($inventories->take(15) as $product)
						@php
							$minPrice = $product->variants->min('price');
							$firstVariant = $product->variants->first();
						@endphp
						<div class="product-card ">
							<div class="position-relative product-items-img">
                                @php
                                    // Use first variant's gallery images if available, otherwise fall back to product's gallery
                                    $gallery = $firstVariant && $firstVariant->gallery_images ? $firstVariant->gallery_images : $product->gallery_images;
                                    $hasGallery = is_array($gallery) && count($gallery) > 0;
                                @endphp
                                @if($hasGallery)
                                    <div id="carousel-{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($gallery as $idx => $img)
                                                <div class="carousel-item{{ $idx === 0 ? ' active' : '' }}">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product['name'] }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if(count($gallery) > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $product->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                @elseif($firstVariant && $firstVariant->main_image)
                                    <img src="{{ asset('storage/' . $firstVariant->main_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product['name'] }}">
                                @elseif($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $product['name'] }}">
                                @endif
							</div>
							<div class="d-flex flex-column justify-content-between gap-3 p-4 text-center ">
								<div>
									<h6 class="product-title mb-3">{{ Str::limit($product['name'], 30) }}</h6>
                                    @if(!empty($product['short_description']))
                                        <p class="product-short-description mb-2">{{ Str::limit($product['short_description'], 30) }}</p>
                                    @endif
									<p class="product-price mb-0">₹{{ $minPrice ?? 'N/A' }}</p>
									<!-- @if($firstVariant)
										<span class="badge bg-light text-dark">Color: {{ $firstVariant->color->name ?? 'N/A' }}</span>
										<span class="badge bg-light text-dark">Size: {{ $firstVariant->size->name ?? 'N/A' }}</span>
									@endif -->
								</div>
								<div class="d-flex gap-2">
									<a href="{{ route('product', $product['id']) }}" class="product-link flex-1">View Product</a>
									@if($firstVariant)
										<button class="border-btn" onclick="quickAddToCart({{ $product['id'] }}, {{ $firstVariant->id }})">Add to Cart</button>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>

	</section>

	<div class="shop-us-section w-100 overflow-hidden">
		<div class="container-ct">
			<h3 class="main-title">Why Shop With Us?</h3>
			<div class="row text-center ">
				<div class="col-md-3 mb-md-0 mb-4 col-sm-6">
					<div class="f-flex flex-column align-items-center justify-content-center shop-card">
						<img src="{{ asset('assets/img/shipping.png') }}" alt="Free Shipping">
						<h5 class="product-title d-block mt-3 mb-2">Free Shipping</h5>
						<p class="product-price mb-0">Available on all prepaid orders</p>
					</div>
				</div>

				<div class="col-md-3 mb-md-0 mb-4 col-sm-6">
					<div class="f-flex flex-column align-items-center justify-content-center shop-card">
						<img src="{{ asset('assets/img/secure.jfif') }}" alt="Secure Payment">
						<h5 class="product-title d-block mt-3 mb-2">Secure Payment</h5>
						<p class="product-price mb-0">Multiple safe payment options</p>
					</div>
				</div>
				<div class="col-md-3 mb-md-0 mb-4 col-sm-6">
					<div class="f-flex flex-column align-items-center justify-content-center shop-card">
						<img src="{{ asset('assets/img/secure.jfif') }}" alt="Secure Payment">
						<h5 class="product-title d-block mt-3 mb-2">Secure Payment</h5>
						<p class="product-price mb-0">Multiple safe payment options</p>
					</div>
				</div>

				<div class="col-md-3 mb-md-0 mb-4 col-sm-6">
					<div class="f-flex flex-column align-items-center justify-content-center shop-card">
						<img src="{{ asset('assets/img/quality.jfif') }}" alt="Premium Quality">
						<h5 class="product-title d-block mt-3 mb-2">Premium Quality</h5>
						<p class="product-price mb-0">Only top-rated products</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Product details page -->
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
	<script>
		function updateQty(change) {
			let qty = document.getElementById('quantity');
			let val = parseInt(qty.value);
			qty.value = Math.max(1, val + change);
		}

		function quickAddToCart(inventoryId, variantId) {
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
					document.getElementById('cartCount').textContent = data.cart_count;

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
					  text: data.message
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

{{-- Ensure Bootstrap CSS is loaded --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

{{-- Ensure Bootstrap JS is loaded for carousel functionality --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
