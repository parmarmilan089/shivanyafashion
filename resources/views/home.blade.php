@extends('front.layout.page')

@section('front-content')
  <main class="main-content position-relative border-radius-lg">
    <!-- Hero Section -->
    <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-12 p-0">
      <div class="position-relative overflow-hidden" style="
        background-image: url('{{ asset('assets/img/banner1.png') }}');
        background-size: cover;
        background-position: center;
        height: 550px;
        margin-top:100px;
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
    </div>
    </div>

    <!-- Categories Section -->
    <div class="container-fluid mt-5">
    <h3 class="text-dark font-weight-bold mb-4">Featured <span class="text-danger">Categories</span></h3>
    <div class="row">
      @foreach ($categorys as $category)
      <div class="col-4 col-md-3 col-lg-2 mb-4">
      <div class="border-0 text-center h-100">
      <!-- <div class="card shadow-sm border-0 text-center h-100"> -->

      <!-- Category Image -->
      <div class="mb-3" style="height: 150px; display: flex; align-items: center; justify-content: center;">
      <img src="{{ asset($category['image']) }}" alt="{{ $category['name'] }}"
        style="max-height: 100%; max-width: 100%; object-fit: contain;border-radius: 76px;">
      </div>

      <!-- Category Name -->
      <h6 class="text-dark fw-semibold">{{ $category['name'] }}</h6>

      </div>
      </div>
    @endforeach
    </div>
    </div>

    <!-- Featured Products Slider -->
    <div class="container-fluid mt-5">
    <h3 class="text-dark font-weight-bold mb-4">Featured <span class="text-danger">Products</span></h3>

    <div class="swiper featuredSwiper swiper-invisible">
      <div class="swiper-wrapper">
      @foreach ($products->take(15) as $product)
      <div class="swiper-slide">
      <div class="card border-0 shadow-sm h-100">
      <!-- Image wrapper with fixed aspect ratio -->
      <div class="position-relative" style="aspect-ratio: 4/5; overflow: hidden;">
        <img src="{{ asset('storage/' . $product->image) }}" class="w-100 h-100 object-fit-cover"
        alt="{{ $product['name'] }}">
      </div>

      <!-- Product Details -->
      <div class="card-body d-flex flex-column justify-content-between">
        <div>
        <h6 class="card-title fw-semibold mb-1">{{ $product['name'] }}</h6>
        <p class="text-dark fw-bold mb-2">₹{{ $product['price'] }}</p>
        </div>
        <a href="{{ route('product',$product['id']) }}" class="btn btn-sm bg-gradient-dark mt-auto">View Product</a>
      </div>
      </div>
      </div>
    @endforeach
      </div>

      <!-- Navigation Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
    </div>

    <div class="container-fluid my-5">
    <h3 class="text-dark font-weight-bold mb-4 text-center">Why <span class="text-danger">Shop</span> With Us?</h3>
    <div class="row text-center mt-5">
      <div class="col-md-3">
      <img src="{{ asset('assets/img/shipping.png') }}" alt="Free Shipping" style="height: 100px;" class="mb-2">
      <h5><span class="text-danger">Free</span> Shipping</h5>
      <p class="text-secondary">Available on all prepaid orders</p>
      </div>

      <div class="col-md-3">
      <img src="{{ asset('assets/img/secure.jfif') }}" alt="Secure Payment" style="height: 100px;" class="mb-2">
      <h5>Secure <span class="text-danger">Payment</span></h5>
      <p class="text-secondary">Multiple safe payment options</p>
      </div>
      <div class="col-md-3">
      <img src="{{ asset('assets/img/secure.jfif') }}" alt="Secure Payment" style="height: 100px;" class="mb-2">
      <h5>Secure Payment</h5>
      <p class="text-secondary">Multiple safe payment options</p>
      </div>

      <div class="col-md-3">
      <img src="{{ asset('assets/img/quality.jfif') }}" alt="Premium Quality" style="height: 100px;" class="mb-2">
      <h5><span class="text-danger">Premium</span> Quality</h5>
      <p class="text-secondary">Only top-rated products</p>
      </div>
    </div>
    </div>
@endsection