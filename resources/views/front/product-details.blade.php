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
                    <script>
    window.productOptionsProps = @json([
        'variants' => $variantData,
    ]);
</script>
					<div id="product-options">
                        <product-options :variants='@json($variantData)'></product-options>
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
