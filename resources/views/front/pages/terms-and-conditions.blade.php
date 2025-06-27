@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg">

  <!-- Hero Banner -->
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-12 p-0">
        <div class="position-relative overflow-hidden"
          style="background-image: url('{{ asset('assets/img/banner1.png') }}'); background-size: cover; background-position: center; height: 300px; margin-top:100px;">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
          <div class="position-relative z-index-2 text-white h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
            <h1 class="display-5 fw-bold text-white">Terms & Conditions</h1>
            <p class="lead">Please read our terms before using our website or services</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Terms Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">

        <h4 class="fw-bold text-dark mb-3">1. Introduction</h4>
        <p>Welcome to <strong>Shivanya Fashion</strong>. By using our website, you agree to these Terms & Conditions. Please read them carefully before browsing or purchasing.</p>

        <h4 class="fw-bold text-dark mt-4">2. Products</h4>
        <p>All items displayed are described and photographed as accurately as possible. Slight variations in color or design may occur due to photography and screen settings.</p>

        <h4 class="fw-bold text-dark mt-4">3. Orders & Payments</h4>
        <ul>
          <li>Orders are processed only after successful payment (unless COD is available).</li>
          <li>We reserve the right to cancel or refuse any order at our discretion.</li>
          <li>All prices include GST unless stated otherwise.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">4. Shipping & Delivery</h4>
        <ul>
          <li>Orders are dispatched within 2–4 working days.</li>
          <li>Shipping is done via trusted courier partners.</li>
          <li>Delivery may take 5–8 working days depending on your location.</li>
          <li>We are not liable for delays caused by courier agencies.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">5. Returns & Exchanges</h4>
        <ul>
          <li>Returns are accepted only for wrong, damaged, or defective products.</li>
          <li>Notify us within 48 hours of delivery along with an unboxing video.</li>
          <li>Products on sale, customized, or clearance are not returnable.</li>
          <li>Return shipping will be handled by us where applicable.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">6. RTO & Payment Recovery</h4>
        <ul>
          <li>If a prepaid order is returned due to delivery failure (RTO), a re-shipping fee may be charged.</li>
          <li>Multiple RTOs or fake CODs may lead to order restrictions.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">7. Account Security</h4>
        <p>You are responsible for maintaining the confidentiality of your account login details. Any misuse should be reported immediately to <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a>.</p>

        <h4 class="fw-bold text-dark mt-4">8. Intellectual Property</h4>
        <p>All content including logos, product images, and descriptions are the property of Shivanya Fashion and cannot be reused without permission.</p>

        <h4 class="fw-bold text-dark mt-4">9. Contact Information</h4>
        <p>For queries related to orders or these terms, reach us via:</p>
        <ul>
          <li>Email: <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a></li>
          <li>WhatsApp: <a href="https://wa.me/919979944324">+91 99799 44324</a></li>
          <li>Instagram: <a href="https://instagram.com/shivanyafashion_1410" target="_blank">@shivanyafashion_1410</a></li>
        </ul>

      </div>
    </div>
  </div>

</main>
@endsection