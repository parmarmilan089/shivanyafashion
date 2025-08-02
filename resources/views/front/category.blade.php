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
            initialProducts: @json($inventories->items()),
            baseUrl : "{{ asset('') }}",
            };
        </script>
  <category-products ></category-products>
  </div>
</div>
@endsection
