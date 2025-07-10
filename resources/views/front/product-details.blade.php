@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg first-section">

<div class="container my-5 ">
    <section class="product-details-section pt-100-ct">
		<div class="container-ct">
			<div class="row">
				<!-- Product Images Section -->
				<div class="col-md-6 mb-md-0 mb-4">
					<div class="w-100">
						@if($product->main_image)
							<img id="mainImage" src="{{ asset('storage/' . $product->main_image) }}" class="w-70 m-auto object-cover" alt="{{ $product->name }}">
						@endif
					</div>
					<div class="product-items-grid">
						@foreach(json_decode($product->gallery_images, true) as $image)
							<div class="w-100 item-product">
								<img src="{{ asset('storage/' . $image) }}"
								class="w-100 h-100 object-cover"
								onclick="document.getElementById('mainImage').src=this.src">
						</div>
						@endforeach
					</div>
				</div>

				<!-- Product Details Section -->
				<div class="col-md-6 position-sticky top-0">
					<p class="product-price mb-2">Category: {{ $product->category->name ?? 'N/A' }}</p>
					<h2 class="product-details-title mb-3">{{ $product->name }}</h2>
					<span class="product-description mb-3 d-block">
					{{ Str::limit($product->short_description, 80) }}
					</span>

					@php
						// Group variants by color
						$colorGroups = $product->variants->groupBy(function($variant) {
							return $variant->color->id ?? 'none';
						});
						$firstColorId = $colorGroups->keys()->first();
						$firstColorVariants = $colorGroups[$firstColorId] ?? collect();
						$firstSizeId = $firstColorVariants->first()->size->id ?? null;
					@endphp
					<div class="mb-3">
						<label for="colorSelect" class="form-label">Color:</label>
						<select id="colorSelect" class="form-select">
							@foreach($colorGroups as $colorId => $variants)
								<option value="{{ $colorId }}">{{ $variants->first()->color->name ?? 'N/A' }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-3">
						<label for="sizeSelect" class="form-label">Size:</label>
						<select id="sizeSelect" class="form-select">
							@foreach($firstColorVariants as $variant)
								<option value="{{ $variant->size->id ?? '' }}" data-price="{{ $variant->price }}">{{ $variant->size->name ?? 'N/A' }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-4">
						<span class="product-title d-block">₹<span id="variantPrice">{{ $firstColorVariants->first()->price ?? 'N/A' }}</span></span>
					</div>
					<div class="mb-sm-4 mb-3 d-flex align-items-center gap-3 flex-sm-row flex-column">
						<div class="input-group-qut d-flex align-items-center gap-2 justify-content-between">
							<button class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt" onclick="updateQty(-1)">-</button>
							<input type="number" id="quantity" value="1" class="p-0 border-0 bg-transparent text-center" min="1">
							<button class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt" onclick="updateQty(1)">+</button>
						</div>
						<button class="w-100 flex-1 border-btn">Add to Cart</button>
					</div>
					<div class="mb-2">
						<span>Total: ₹<span id="totalPrice">{{ $firstColorVariants->first()->price ?? 'N/A' }}</span></span>
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
</div>
</main>
@endsection
@section('script')
<script>
    function updateQty(change) {
        let qty = document.getElementById('quantity');
        let val = parseInt(qty.value);
        qty.value = Math.max(1, val + change);
    }

    const variants = @json($product->variants->map(function($v) {
        return [
            'color_id' => $v->color->id ?? null,
            'color_name' => $v->color->name ?? '',
            'size_id' => $v->size->id ?? null,
            'size_name' => $v->size->name ?? '',
            'price' => $v->price,
        ];
    });
    let qtyInput = document.getElementById('quantity');
    let colorSelect = document.getElementById('colorSelect');
    let sizeSelect = document.getElementById('sizeSelect');
    let priceSpan = document.getElementById('variantPrice');
    let totalSpan = document.getElementById('totalPrice');

    function updateSizes() {
        let colorId = colorSelect.value;
        let sizes = variants.filter(v => v.color_id == colorId);
        sizeSelect.innerHTML = '';
        sizes.forEach(function(v, idx) {
            let opt = document.createElement('option');
            opt.value = v.size_id;
            opt.text = v.size_name;
            opt.setAttribute('data-price', v.price);
            sizeSelect.appendChild(opt);
        });
        updatePrice();
    }
    function updatePrice() {
        let selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
        let price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
        let qty = parseInt(qtyInput.value) || 1;
        priceSpan.textContent = price;
        totalSpan.textContent = price * qty;
    }
    colorSelect.addEventListener('change', function() {
        updateSizes();
    });
    sizeSelect.addEventListener('change', function() {
        updatePrice();
    });
    qtyInput.addEventListener('input', function() {
        updatePrice();
    });
    // Initial update
    updateSizes();
</script>
@endsection