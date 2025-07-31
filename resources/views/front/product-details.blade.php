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
</div>
</main>
@endsection
