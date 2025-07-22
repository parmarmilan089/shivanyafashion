@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-12 p-0">
        <div class="position-relative overflow-hidden"
          style="background-image: url('{{ asset('assets/img/banner1.png') }}'); background-size: cover; background-position: center; height: 300px; margin-top:100px;">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
          <div class="position-relative z-index-2 text-white h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
            <h1 class="display-5 fw-bold text-white">Returns & Exchanges</h1>
            <p class="lead">Our policy for returns, exchanges, and refunds</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h4 class="fw-bold text-dark mb-3">Eligibility for Returns</h4>
        <ul>
          <li>Returns are accepted only for wrong, damaged, or defective products.</li>
          <li>Products must be unused, unwashed, and in original packaging with tags.</li>
          <li>Products on sale, customized, or clearance are not returnable.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">How to Initiate a Return</h4>
        <ol>
          <li>Contact us within 48 hours of delivery at <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a> or WhatsApp <a href="https://wa.me/919979944324">+91 99799 44324</a>.</li>
          <li>Share your order number, reason for return, and an unboxing video/photo as proof.</li>
          <li>Our team will review and arrange a pickup if eligible.</li>
        </ol>

        <h4 class="fw-bold text-dark mt-4">Refunds & Exchanges</h4>
        <ul>
          <li>Refunds are processed to the original payment method within 5-7 business days after product inspection.</li>
          <li>Exchanges are subject to stock availability.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">Contact</h4>
        <p>For any return-related queries, email us at <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a> or WhatsApp <a href="https://wa.me/919979944324">+91 99799 44324</a>.</p>
      </div>
    </div>
  </div>
</main>
@endsection
