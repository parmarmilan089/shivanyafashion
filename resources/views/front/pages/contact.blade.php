@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg">
  <!-- Banner Section -->
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-12 p-0">
        <div class="position-relative overflow-hidden"
          style="background-image: url('{{ asset('assets/img/banner1.png') }}'); background-size: cover; background-position: center; height: 300px; margin-top:100px;">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
          <div class="position-relative z-index-2 text-white h-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
            <h1 class="display-5 fw-bold text-white">Contact Us</h1>
            <p class="lead">We’d love to hear from you</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Info & Form Section -->
  <div class="container my-5">
    <div class="row gy-5">
      <!-- Contact Details -->
      <div class="col-lg-5">
        <h4 class="fw-bold text-dark mb-3">Get In Touch</h4>
        <p>Whether it's a question about your order, our products, or partnership opportunities — we're here to help.</p>

        <ul class="list-unstyled mb-4">
          <li class="mb-2"><strong>Email:</strong> <a href="mailto:shivanyafs@gmail.com">shivanyafs@gmail.com</a></li>
          <li class="mb-2"><strong>WhatsApp:</strong> <a href="https://wa.me/919979944324">+91 99799 44324</a></li>
          <li class="mb-2"><strong>Instagram:</strong> <a href="https://instagram.com/shivanyafashion_1410" target="_blank">@shivanyafashion_1410</a></li>
        </ul>

        <h5 class="fw-bold mt-4">Business Hours</h5>
        <p>Monday – Saturday: 10:00 AM to 7:00 PM<br>Sunday: Closed</p>

        <h5 class="fw-bold mt-4">Help Topics</h5>
        <ul class="list-unstyled">
          <li><i class="material-icons text-sm text-dark">help_outline</i> Order Status & Tracking</li>
          <li><i class="material-icons text-sm text-dark">autorenew</i> Returns & Exchanges</li>
          <li><i class="material-icons text-sm text-dark">storefront</i> Bulk or Wholesale Inquiries</li>
        </ul>

        <h5 class="fw-bold mt-4">Visit Our Office</h5>
        <p>Shivanya Fashion<br>Surat, Gujarat – India</p>

        <!-- Optional Google Map Embed -->
        <div class="ratio ratio-16x9 mt-3">
          <iframe class="rounded" src="https://www.google.com/maps/embed?pb=!1m18!..." frameborder="0" allowfullscreen></iframe>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7">
        <h4 class="fw-bold text-dark mb-4">Send Us a Message</h4>
        <form method="POST" action="">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Your Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="John Doe" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Your Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" required>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" name="phone" class="form-control" id="phone" placeholder="+91 98765 43210" required>
            </div>
            <div class="col-md-6">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control" id="subject" placeholder="Order Inquiry">
            </div>
            <div class="col-12">
              <label for="message" class="form-label">Your Message</label>
              <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write your message here..." required></textarea>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-dark mt-3 px-4 py-2">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection
