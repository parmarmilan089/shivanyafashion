<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/shivanya.png') }}">
  <title>
    Shivanya Fashion
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('assets/css/material-dashboard.css?v=3.2.0')}}" rel="stylesheet" />
  <link id="pagestyle" href="{{asset('assets/css/front-style.css')}}" rel="stylesheet" />
  <!-- Add to <head> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
</head>

<body class="">
  <header class="header-section position-fixed left-0 top-0 w-100 z-index-9999">
    <div class="container-ct">
      <nav class="navbar navbar-expand-lg shadow-none">
          <!-- Logo -->
          <a class="navbar-brand ms-lg-0 ms-3 d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/header-logo.png') }}" alt="Shivanya Fashion" style="height: 40px;">
          </a>

          <!-- Toggler -->
          <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </span>
          </button>

          <!-- Dynamic Navigation Menu -->
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav mx-auto">
              @php
        $categories = \App\Helpers\Helper::getMenuCategories();
        @endphp

              @foreach ($categories as $mainCategory)
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown{{ $mainCategory->id }}" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              {{ $mainCategory->name }}
            </a>

            @if ($mainCategory->children->isNotEmpty())
            <ul class="dropdown-menu" aria-labelledby="dropdown{{ $mainCategory->id }}">
            @foreach ($mainCategory->children as $child)
            @if ($child->children->isNotEmpty())
            <li class="dropdown-submenu position-relative">
            <a class="dropdown-item dropdown-toggle" href="#">{{ $child->name }}</a>
            <ul class="dropdown-menu shadow" style="top: 0; left: 100%; margin-top: -1px;">
            @foreach ($child->children as $subChild)
          <li>
          <a class="dropdown-item" href="">
          {{ $subChild->name }}
          </a>
          </li>
          @endforeach
            </ul>
            </li>
          @else
          <li>
          <a class="dropdown-item" href="">
            {{ $child->name }}
          </a>
          </li>
          @endif
          @endforeach
            </ul>
        @endif
            </li>
        @endforeach

              <!-- Static Links -->
              <li class="nav-item"><a class="nav-link" href="#">Offers</a></li>
              <li class="nav-item"><a class="nav-link" href="#">New Arrivals</a></li>
            </ul>

            <!-- Right Side Icons -->
            <ul class="navbar-nav d-lg-flex flex-row align-items-center gap-3 pe-3 icon-list">
              <!-- Search -->
              <li class="nav-item d-none d-lg-block">
                <form method="GET" action="" class="d-flex align-items-center">
                  <label for="searchInput" class="me-2 mb-0">
                    <i class="material-symbols-rounded text-dark" style="font-size: 22px;">search</i>
                  </label>
                  <div class="input-group input-group-outline my-0">
                    <input type="text" id="searchInput" name="q" class="form-control form-control-sm"
                      placeholder="Search..." onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </form>
              </li>

              <!-- Wishlist -->
              <li class="nav-item">
                <a href="" class="nav-link px-2">
                  <i class="material-symbols-rounded" style="font-size: 26px;">favorite</i>
                </a>
              </li>

              <!-- Cart -->
              <li class="nav-item position-relative">
                <a href="#" class="nav-link px-2" id="cartToggle">
                  <i class="material-symbols-rounded text-dark" style="font-size: 26px;">shopping_cart</i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">
                    {{ \App\Helpers\Helper::getCartCount() }}
                  </span>
                </a>
              </li>

              <!-- Profile -->
              @auth('customer')
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="customerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="material-symbols-rounded text-dark me-2" style="font-size: 26px;">person</i>
                    <span class="text-dark">{{ auth('customer')->user()->name }}</span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="customerDropdown">
                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}"><i class="material-symbols-rounded me-2">account_circle</i>Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('customer.orders') }}"><i class="material-symbols-rounded me-2">receipt</i>Orders</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ url('customer/logout') }}"><i class="material-symbols-rounded me-2">logout</i>Logout</a></li>
                  </ul>
                </li>
              @else
                <li class="nav-item">
                  <a href="{{ route('customer.login') }}" class="nav-link px-2">
                    <i class="material-symbols-rounded text-dark" style="font-size: 26px;">person</i>
                  </a>
                </li>
              @endauth
            </ul>
          </div>
      </nav>
    </div>
  </header>
  <main class="main-content position-relative h-100 front-main-content">
    @yield('front-content')
  </main>
  <footer class="bg-gradient-dark text-white mt-5 pt-5 pb-6">
    <div class="container">
      <div class="row">
        <!-- Logo and Tagline -->
        <div class="col-md-4 mb-3">
          <img src="{{ asset('assets/img/logo-white.png') }}" alt="Shivanya Fashion" style="height: 50px;">
          <p class="text-sm">We bring the latest ethnic trends from across India, right to your doorstep.</p>
        </div>

        <!-- Quick Links -->
        <div class="col-md-4 mb-3 mt-2">
          <h6 class="text-uppercase text-white">Quick Links</h6>
          <ul class="list-unstyled text-sm">
            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
            <li><a href="{{ url('/store') }}" class="text-white">Store</a></li>
            <li><a href="{{ route('front.about') }}" class="text-white">About Us</a></li>
            <li><a href="{{ route('front.contact') }}" class="text-white">Contact Us</a></li>
            <li><a href="{{ route('front.terms') }}" class="text-white">Terms & Conditions</a></li>
            <li><a href="{{ route('front.privacy') }}" class="text-white">Privacy Policy</a></li>
            <li><a href="{{ url('/customer/login') }}" class="text-white">Login</a></li>
            <li><a href="{{ url('/customer/register') }}" class="text-white">Register</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="col-md-4 mb-3">
          <h6 class="text-uppercase text-white">Contact</h6>
          <p class="text-sm mb-1">Email: <a href="mailto:shivanyafs@gmail.com"
              class="text-white">shivanyafs@gmail.com</a></p>
          <p class="text-sm">WhatsApp: <a href="https://wa.me/919979944324" class="text-white">+91 99799 44324</a></p>
        </div>
      </div>

      <hr class="border-light">
      <p class="text-center text-sm mt-2">© {{ date('Y') }} Shivanya Fashion. All rights reserved.</p>
    </div>
  </footer>

  <!--   Core JS Files   -->
  <!-- Include jQuery (necessary for DataTables.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Include DataTables JS -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/choices.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <script src="{{asset('assets/js/datatables.js')}}"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <!-- Add before </body> -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
    const swiper = new Swiper(".featuredSwiper", {
      slidesPerView: 1,
      spaceBetween: 15,
      loop: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      },
      breakpoints: {
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        992: { slidesPerView: 4 },
        1200: { slidesPerView: 5 }
      },
      on: {
        init: function () {
          document.querySelector('.featuredSwiper').classList.remove('swiper-invisible');
        }
      }
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/material-dashboard.js')}}"></script>
  @vite('resources/js/app.js')

  <!-- Cart Sidebar JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cartToggle = document.getElementById('cartToggle');
      const cartSidebar = document.getElementById('cartSidebar');
      const cartOverlay = document.getElementById('cartOverlay');
      const cartClose = document.getElementById('cartClose');
      const cartBody = document.getElementById('cartBody');
      const cartFooter = document.getElementById('cartFooter');
      const cartCount = document.getElementById('cartCount');
      const cartTotal = document.getElementById('cartTotal');
      const clearCartBtn = document.getElementById('clearCartBtn');
      const checkoutBtn = document.getElementById('checkoutBtn');

      // Toggle cart sidebar
      function toggleCart() {
        cartSidebar.classList.toggle('active');
        cartOverlay.classList.toggle('active');
        if (cartSidebar.classList.contains('active')) {
          loadCart();
        }
      }

      // Load cart data
      function loadCart() {
        fetch('/cart/get')
          .then(response => response.json())
          .then(data => {
            console.log(data,'data');
            updateCartDisplay(data);
          })
          .catch(error => {
            console.error('Error loading cart:', error);
          });
      }

      // Update cart display
      function updateCartDisplay(data) {
        cartCount.textContent = data.cart_count;

        if (data.cart_count === 0) {
          cartBody.innerHTML = `
            <div class="cart-empty text-center py-5">
              <i class="material-symbols-rounded text-muted" style="font-size: 48px;">shopping_cart</i>
              <p class="text-muted mt-3">Your cart is empty</p>
            </div>
          `;
          cartFooter.style.display = 'none';
        } else {
          let cartHtml = '';
          Object.keys(data.cart).forEach(key => {
            const item = data.cart[key];
            cartHtml += `
              <div class="cart-item" data-cart-key="${key}">
                <img src="${item.image}" alt="${item.product_name}" class="cart-item-image">
                <div class="cart-item-details">
                  <div class="cart-item-name">${item.product_name}</div>
                  <div class="cart-item-variant">
                    ${item.color_name ? 'Color: ' + item.color_name : ''}
                    ${item.size_name ? 'Size: ' + item.size_name : ''}
                  </div>
                  <div class="cart-item-price">₹${item.price}</div>
                  <div class="cart-item-quantity">
                    <button class="quantity-btn" onclick="updateQuantity('${key}', -1)">-</button>
                    <input type="number" class="quantity-input" value="${item.quantity}"
                           min="1" onchange="updateQuantity('${key}', this.value, true)">
                    <button class="quantity-btn" onclick="updateQuantity('${key}', 1)">+</button>
                    <button class="cart-item-remove" onclick="removeFromCart('${key}')">
                      <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                    </button>
                  </div>
                </div>
              </div>
            `;
          });
          cartBody.innerHTML = cartHtml;
          cartTotal.textContent = '₹' + data.cart_total.toFixed(2);
          cartFooter.style.display = 'block';
        }
      }

      // Update quantity
      window.updateQuantity = function(cartKey, change, isDirectInput = false) {
        let newQuantity;
        if (isDirectInput) {
          newQuantity = parseInt(change);
        } else {
          const currentQuantity = parseInt(document.querySelector(`[data-cart-key="${cartKey}"] .quantity-input`).value);
          newQuantity = currentQuantity + parseInt(change);
        }

        if (newQuantity < 1) return;

        fetch('/cart/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            cart_key: cartKey,
            quantity: newQuantity
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadCart();
          }
        })
        .catch(error => {
          console.error('Error updating cart:', error);
        });
      };

      // Remove from cart
      window.removeFromCart = function(cartKey) {
        fetch('/cart/remove', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            cart_key: cartKey
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            loadCart();
          }
        })
        .catch(error => {
          console.error('Error removing from cart:', error);
        });
      };

      // Clear cart
      clearCartBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your cart?')) {
          fetch('/cart/clear', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              loadCart();
            }
          })
          .catch(error => {
            console.error('Error clearing cart:', error);
          });
        }
      });

      // Checkout button
      checkoutBtn.addEventListener('click', function() {
        // Redirect to checkout page or show checkout modal
        alert('Checkout functionality will be implemented here');
      });

      // Event listeners
      cartToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleCart();
      });

      cartClose.addEventListener('click', toggleCart);
      cartOverlay.addEventListener('click', toggleCart);

      // Close cart on escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && cartSidebar.classList.contains('active')) {
          toggleCart();
        }
      });
    });
  </script>

  <!-- Cart Sidebar -->
  <div class="cart-sidebar" id="cartSidebar">
    <div class="cart-sidebar-header">
      <h5 class="mb-0">Shopping Cart</h5>
      <button type="button" class="btn-close" id="cartClose"></button>
    </div>

    <div class="cart-sidebar-body" id="cartBody">
      <!-- Cart items will be loaded here -->
      <div class="cart-empty text-center py-5">
        <i class="material-symbols-rounded text-muted" style="font-size: 48px;">shopping_cart</i>
        <p class="text-muted mt-3">Your cart is empty</p>
      </div>
    </div>

    <div class="cart-sidebar-footer" id="cartFooter" style="display: none;">
      <div class="cart-total mb-3">
        <div class="d-flex justify-content-between">
          <span>Total:</span>
          <span class="fw-bold" id="cartTotal">₹0.00</span>
        </div>
      </div>
      <div class="d-grid gap-2">
        <button type="button" class="btn btn-primary" id="checkoutBtn">Proceed to Checkout</button>
        <button type="button" class="btn btn-outline-secondary" id="clearCartBtn">Clear Cart</button>
      </div>
    </div>
  </div>

  <!-- Cart Overlay -->
  <div class="cart-overlay" id="cartOverlay"></div>

</body>

</html>
