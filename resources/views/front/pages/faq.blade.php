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
            <h1 class="display-5 fw-bold text-white">Frequently Asked Questions</h1>
            <p class="lead">Find answers to common questions about shopping with us</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="faq1">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                How do I place an order?
              </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Browse our products, add your favorites to the cart, and proceed to checkout. Fill in your details and complete payment to place your order.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="faq2">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                What payment methods do you accept?
              </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                We accept all major credit/debit cards, UPI, net banking, and Cash on Delivery (COD) where available.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="faq3">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                How can I track my order?
              </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Once your order is shipped, you will receive a tracking link via email and WhatsApp. You can also check order status in your account.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="faq4">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                What is your return policy?
              </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Returns are accepted for wrong, damaged, or defective products. Please refer to our <a href="{{ route('front.pages.returns') }}">Returns Policy</a> for details.
              </div>
            </div>
          </div>
          <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="faq5">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                How do I contact customer support?
              </button>
            </h2>
            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                You can reach us at <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a> or WhatsApp <a href="https://wa.me/919979944324">+91 99799 44324</a>.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
