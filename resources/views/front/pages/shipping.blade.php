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
            <h1 class="display-5 fw-bold text-white">Shipping Information</h1>
            <p class="lead">Learn about our shipping process, timelines, and partners</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h4 class="fw-bold text-dark mb-3">Dispatch & Delivery</h4>
        <ul>
          <li>Orders are dispatched within 2–4 working days after payment confirmation.</li>
          <li>Delivery takes 5–8 working days depending on your location.</li>
          <li>We use trusted courier partners for safe and timely delivery.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">Shipping Charges</h4>
        <ul>
          <li>Shipping is free for prepaid orders above ₹999.</li>
          <li>For orders below ₹999, a nominal shipping fee is applied at checkout.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">Order Tracking</h4>
        <ul>
          <li>Once shipped, you will receive a tracking link via email and WhatsApp.</li>
          <li>You can also track your order status in your account dashboard.</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">International Shipping</h4>
        <p>Currently, we ship only within India. For international inquiries, please contact us directly.</p>

        <h4 class="fw-bold text-dark mt-4">Contact</h4>
        <p>For shipping-related questions, email <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a> or WhatsApp <a href="https://wa.me/919979944324">+91 99799 44324</a>.</p>
      </div>
    </div>
  </div>
</main>
@endsection
