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
            <h1 class="display-5 fw-bold text-white">Privacy Policy</h1>
            <p class="lead">How we collect, use, and protect your data</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h4 class="fw-bold text-dark mb-3">1. Information We Collect</h4>
        <p>We collect basic customer information like name, email, phone, and shipping address during registration or checkout.</p>

        <h4 class="fw-bold text-dark mt-4">2. How We Use It</h4>
        <ul>
          <li>To process orders and send confirmations</li>
          <li>To provide shipping and delivery updates</li>
          <li>To respond to queries or support requests</li>
          <li>To improve our products and services</li>
        </ul>

        <h4 class="fw-bold text-dark mt-4">3. Data Protection</h4>
        <p>We use secure technologies and payment gateways to protect your information. Your data is never shared with third parties for marketing.</p>

        <h4 class="fw-bold text-dark mt-4">4. Contact</h4>
        <p>If you have any questions about this privacy policy, contact us at <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a>.</p>
      </div>
    </div>
  </div>
</main>
@endsection
