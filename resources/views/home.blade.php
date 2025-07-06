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
						<div class="categories-card-img w-100 overflow-hidden flex-1">
							<!-- <img src="{{ asset($category['image']) }}" alt="{{ $category['name'] }}" class="w-100 h-100 object-cover"> -->
							<img src="//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906&width=165 165w,//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906&width=360 360w,//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906&width=533 533w,//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906&width=720 720w,//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906&width=940 940w,//dt-vogue.myshopify.com/cdn/shop/files/fashionproduct1.jpg?v=1698831906 950w"
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
					@foreach ($products->take(15) as $product)
						<div class="product-card ">
							<div class="position-relative product-items-img">
								<img src="https://dt-vogue.myshopify.com/cdn/shop/files/Product13.0.jpg?v=1699086311&width=533"
									class="w-100 h-100 object-fit-cover" alt="{{ $product['name'] }}">
							</div>
							<div class="d-flex flex-column justify-content-between gap-3 p-4 text-center ">
								<div>
									<h6 class="product-title mb-3">{{ $product['name'] }}</h6>
									<p class="product-price mb-0">₹{{ $product['price'] }}</p>
								</div>
								<a href="{{ route('product', $product['id']) }}" class="product-link">View Product</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<!-- <div class="swiper featuredSwiper swiper-invisible">
																												<div class="swiper-wrapper">
																													@foreach ($products->take(15) as $product)
																														<div class="swiper-slide">
																															<div class="card border-0 shadow-sm h-100">
																																<div class="position-relative" style="aspect-ratio: 4/5; overflow: hidden;">
																																	<img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover"
																																		alt="{{ $product['name'] }}">
																																</div>

																																<div class="card-body d-flex flex-column justify-content-between">
																																	<div>
																																		<h6 class="card-title fw-semibold mb-1">{{ $product['name'] }}</h6>
																																		<p class="text-dark fw-bold mb-2">₹{{ $product['price'] }}</p>
																																	</div>
																																	<a href="{{ route('product', $product['id']) }}"
																																		class="btn btn-sm bg-gradient-dark mt-auto">View
																																		Product</a>
																																</div>
																															</div>
																														</div>
																													@endforeach
																												</div> -->

		<!-- Navigation Arrows -->
		<!-- <div class="swiper-button-next"></div>
																												<div class="swiper-button-prev"></div> -->
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
		<div class="container-ct">
			<div class="row">
				<!-- Product Images Section -->
				<div class="col-md-6 mb-md-0 mb-4">
					<div class="w-100">
						<img id="mainImage"
							src="https://dt-vogue.myshopify.com/cdn/shop/files/f1.jpg?v=1701491555&width=493"
							class="h-100 w-100 object-cover" alt="{{ $product->name }}">
					</div>
					<div class="product-items-grid">
						<div class="w-100 item-product">
							<img src="https://dt-vogue.myshopify.com/cdn/shop/files/f1.jpg?v=1701491555&width=493"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						<div class="w-100 item-product">
							<img src="	https://dt-vogue.myshopify.com/cdn/shop/files/Product6.0.jpg?v=1699086092&width=360"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						<div class="w-100 item-product">
							<img src="https://dt-vogue.myshopify.com/cdn/shop/files/f1.jpg?v=1701491555&width=493"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						<div class="w-100 item-product">
							<img src="	https://dt-vogue.myshopify.com/cdn/shop/files/Product6.0.jpg?v=1699086092&width=360"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						<div class="w-100 item-product">
							<img src="https://dt-vogue.myshopify.com/cdn/shop/files/f1.jpg?v=1701491555&width=493"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						<div class="w-100 item-product">
							<img src="	https://dt-vogue.myshopify.com/cdn/shop/files/Product6.0.jpg?v=1699086092&width=360"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
					</div>
				</div>

				<!-- Product Details Section -->
				<div class="col-md-6 position-sticky top-0">
					<p class="product-price mb-2">Category: {{ $product->category->name ?? 'N/A' }}</p>
					<h2 class="product-details-title mb-3">{{ $product->name }}</h2>
					<span class="product-description mb-3 d-block">
						This gorgeous dress's appealing silhouette, versatile embroidery, and elegant fabric are meant to
						make you feel like a queen ideal for red carpet events, weddings, and special occasions.
					</span>

					<div class="mb-4">
						<span class="product-title d-block">₹{{ $product->discount_price ?? $product->price }}</span>
						@if ($product->discount_price)
							<span class="product-title d-block">₹{{ $product->price }}</span>
							<span class="product-title d-block">₹{{ $product->price - $product->discount_price }} OFF</span>
						@endif
					</div>
					<!-- Quantity Selector -->
					<div class="mb-sm-4 mb-3 d-flex align-items-center gap-3 flex-sm-row flex-column">
						<div class="input-group-qut d-flex align-items-center gap-2 justify-content-between">
							<button
								class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt"
								onclick="updateQty(-1)">-</button>
							<input type="number" id="quantity" value="1" class="p-0 border-0 bg-transparent text-center"
								min="1">
							<button
								class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt"
								onclick="updateQty(1)">+</button>
						</div>
						<button class="w-100 flex-1 border-btn">Add to Cart</button>
					</div>

					<!-- Action Buttons -->
					<button class="border-btn w-100">Buy it Now</button>

					<!-- Trust Badges -->
					<div class="mt-4 w-100 d-flex flex-column gap-4 product-shipping-detail">
						<div class="d-flex align-items-center w-100 gap-2"><i class="fa fa-shield-alt me-1 text-dark"></i>
							<span class="w-100 flex-1">
								Secure Checkout
							</span>
						</div>
						<div class="d-flex align-items-center w-100 gap-2"><i class="fa fa-truck me-1 text-dark"></i>
							<span class="w-100 flex-1">
								Free Shipping
							</span>
						</div>
						<div class="d-flex align-items-center w-100 gap-2"><i class="fa fa-undo me-1 text-dark"></i>
							<span class="w-100 flex-1">Easy Returns</span>
						</div>
						<div class="d-flex align-items-center w-100 gap-2"><i class="fa fa-headset me-1 text-dark"></i>
							<span class="w-100 flex-1"> 24/7 Support</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>
		function updateQty(change) {
			let qty = document.getElementById('quantity');
			let val = parseInt(qty.value);
			qty.value = Math.max(1, val + change);
		}
	</script>
@endsection