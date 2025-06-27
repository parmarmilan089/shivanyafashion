@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg">
  <!-- Hero Section -->
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-12 p-0">
        <div class="position-relative overflow-hidden"
          style="background-image: url('{{ asset('assets/img/banner1.png') }}'); background-size: cover; background-position: center; height: 350px; margin-top:100px;">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
          <div class="position-relative z-index-2 text-white h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
            <h1 class="display-5 fw-bold text-white">About Us</h1>
            <p class="lead">Celebrating Culture Through Contemporary Ethnic Wear</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img src="{{ asset('assets/img/about-us-1.jpg') }}" alt="About Shivanya Fashion" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-3">Who We Are</h4>
        <p><strong>Shivanya Fashion</strong> is a modern ethnic wear brand dedicated to delivering elegance, tradition, and celebration to every wardrobe. We focus on curating fashion-forward designs with a cultural essence — making you stand out during every festive moment.</p>
      </div>
    </div>

    <div class="row align-items-center mt-5 flex-md-row-reverse">
      <div class="col-md-6">
        <img src="{{ asset('assets/img/about-us-2.jpg') }}" alt="Our Mission" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-3">Our Vision</h4>
        <p>Our vision is to empower women by offering clothing that enhances their individuality. We believe in combining classic ethnic vibes with contemporary styles, ensuring every piece reflects grace, confidence, and personality.</p>
      </div>
    </div>

    <div class="row align-items-center mt-5">
      <div class="col-md-6">
        <img src="{{ asset('assets/img/about-us-3.jpg') }}" alt="Why Choose Us" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h4 class="fw-bold text-dark mb-3">Why Choose Shivanya Fashion?</h4>
        <ul class="text-dark">
          <li class="mb-2">✨ <strong>Unique Designs</strong> – Handpicked and exclusive seasonal pieces.</li>
          <li class="mb-2">🧵 <strong>Quality Fabric</strong> – Carefully sourced materials for comfort & elegance.</li>
          <li class="mb-2">🚚 <strong>Fast Delivery</strong> – Quick dispatch & reliable logistics.</li>
          <li class="mb-2">💬 <strong>Customer First</strong> – Friendly support and easy returns.</li>
        </ul>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col text-center">
        <h4 class="fw-bold text-dark mb-3">Stay Connected</h4>
        <p>Join our fashion family and never miss an update on new arrivals, festive collections, and exclusive offers.</p>
        <p class="mb-1">📧 Email: <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a></p>
        <p class="mb-1">📱 WhatsApp: <a href="https://wa.me/919979944324" target="_blank">+91 99799 44324</a></p>
        <p>📸 Instagram: <a href="https://instagram.com/shivanyafashion_1410" target="_blank">@shivanyafashion_1410</a></p>
      </div>
    </div>
  </div>
</main>
@endsection
