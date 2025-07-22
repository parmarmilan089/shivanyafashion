@extends('front.layout.page')

@section('front-content')
<div class="container my-5">
  <h2 class="mb-4">{{ $category->name }}</h2>
  <category-products
    :category-id="{{ $category->id }}"
    :colors='@json($colors)'
    :min-price="{{ $minPrice }}"
    :max-price="{{ $maxPrice }}"
    :initial-products='@json($products)'
  ></category-products>
</div>
@endsection
