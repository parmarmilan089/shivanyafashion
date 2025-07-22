@extends('front.layout.page')

@section('front-content')
<h2 class="mb-4">{{ $category->name }}</h2>
<div class="container my-5" id="category-products">
    @php
    $Objectdata = [
        'categoryId' => $category->id,
        'colors' => $colors,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'products' => $products,
        ];
    @endphp
    <script>
        window.categoryProductsProps = @json([
            'category' => $Objectdata
        ]);
    </script>
    <category-products></category-products>
</div>
@endsection
