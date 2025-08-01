@extends('front.layout.page')

@section('front-content')
<div class="container my-5" >
  <h2 class="mb-4">{{ $category->name }}</h2>
  <div id="category-products">
        <script>
            window.categoryProductsProps = {
            categoryId: {{ $category->id }},
            colors: @json($colors),
            minPrice: {{ (float) $minPrice }},
            maxPrice: {{ (float) $maxPrice }},
            initialProducts: @json($inventories->items())
            };
        </script>
  <category-products
    :category-id="{{ $category->id }}"
    :colors='@json($colors)'
    :min-price="{{ $minPrice }}"
    :max-price="{{ $maxPrice }}"
    :initial-products='@json($inventories->items())'
  ></category-products>
  </div>
</div>
@endsection
