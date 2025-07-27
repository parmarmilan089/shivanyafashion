@extends('front.layout.page')

@section('front-content')
    <main class="main-content position-relative border-radius-lg first-section">
        <div class="container">
            <h2 class=" product-title d-block mb-3 mt-sm-5 mt-4">Checkout</h2>
            @php $cart = session('cart', []);
            $cart_total = 0; @endphp
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(count($cart))
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-7">
                        <form method="POST" action="{{ route('checkout.process') }}">
                            @csrf
                            <div class="card-border">
                                <h5 class="mb-3">Billing Details</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Name</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="billing_name" class="form-control" required
                                                placeholder="Name" value="{{ old('billing_name') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="billing_phone" class="form-control" required
                                                placeholder="Phone" value="{{ old('billing_phone') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="email" name="billing_email" class="form-control" required
                                                placeholder="Email" value="{{ old('billing_email') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Flat, House no., Building, Company, Apartment</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="billing_address_line1" class="form-control" required
                                                placeholder="Flat, House no., Building, Company, Apartment"
                                                value="{{ old('billing_address_line1') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Area, Street, Sector, Village</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="billing_address_line2" class="form-control" required
                                                placeholder="Area, Street, Sector, Village"
                                                value="{{ old('billing_address_line2') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>State</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="billing_state" id="billing_state" class="form-control" required
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="">Select State</option>
                                                <option value="Maharashtra" {{ old('billing_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                                <option value="Delhi" {{ old('billing_state') == 'Delhi' ? 'selected' : '' }}>
                                                    Delhi</option>
                                                <option value="Karnataka" {{ old('billing_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                                <option value="Tamil Nadu" {{ old('billing_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                                <option value="West Bengal" {{ old('billing_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                                <option value="Gujarat" {{ old('billing_state') == 'Gujarat' ? 'selected' : '' }}>
                                                    Gujarat</option>
                                                <option value="Uttar Pradesh" {{ old('billing_state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                                <option value="Rajasthan" {{ old('billing_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                                <option value="Madhya Pradesh" {{ old('billing_state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                                <option value="Punjab" {{ old('billing_state') == 'Punjab' ? 'selected' : '' }}>
                                                    Punjab</option>
                                                <!-- Add more states as needed -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>City</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="billing_city" id="billing_city" class="form-control" required disabled
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Pincode</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="billing_pincode" class="form-control" required
                                                placeholder="Pincode" value="{{ old('billing_pincode') }}"
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3 mt-3 p-0">
                                <input class="form-check-input" type="checkbox" value="1" id="copyBilling"
                                    onclick="copyBillingToShipping()">
                                <label class="form-check-label" for="copyBilling">
                                    Shipping details same as billing
                                </label>
                            </div>
                            <div class="card-border mb-4">
                                <h5 class="mb-3">Shipping Details</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Name</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_name" class="form-control" required
                                                placeholder="Name" value="{{ old('shipping_name') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="email" name="shipping_email" class="form-control" required
                                                placeholder="Email" value="{{ old('shipping_email') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_phone" class="form-control" required
                                                placeholder="Phone" value="{{ old('shipping_phone') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Alternate Phone</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_alt_phone" class="form-control"
                                                placeholder="Alternate Phone" value="{{ old('shipping_alt_phone') }}"
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Flat, House no., Building, Company, Apartment</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_address_line1" class="form-control" required
                                                placeholder="Flat, House no., Building, Company, Apartment"
                                                value="{{ old('shipping_address_line1') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Area, Street, Sector, Village</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_address_line2" class="form-control" required
                                                placeholder="Area, Street, Sector, Village"
                                                value="{{ old('shipping_address_line2') }}" onfocus="focused(this)"
                                                onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>State</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="shipping_state" id="shipping_state" class="form-control" required
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="">Select State</option>
                                                <option value="Maharashtra" {{ old('shipping_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                                <option value="Delhi" {{ old('shipping_state') == 'Delhi' ? 'selected' : '' }}>
                                                    Delhi</option>
                                                <option value="Karnataka" {{ old('shipping_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                                <option value="Tamil Nadu" {{ old('shipping_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                                <option value="West Bengal" {{ old('shipping_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                                <option value="Gujarat" {{ old('shipping_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                                <option value="Uttar Pradesh" {{ old('shipping_state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                                <option value="Rajasthan" {{ old('shipping_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                                <option value="Madhya Pradesh" {{ old('shipping_state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                                <option value="Punjab" {{ old('shipping_state') == 'Punjab' ? 'selected' : '' }}>
                                                    Punjab</option>
                                                <!-- Add more states as needed -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>City</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="shipping_city" id="shipping_city" class="form-control" required
                                                disabled onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Pincode</label>
                                        <div class="input-group input-group-outline my-0">
                                            <input type="text" name="shipping_pincode" class="form-control" required
                                                placeholder="Pincode" value="{{ old('shipping_pincode') }}"
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Country</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="shipping_country" class="form-control" required
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="India" {{ old('shipping_country', 'India') == 'India' ? 'selected' : '' }}>India</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Address Type</label>
                                        <div class="input-group input-group-outline my-0">
                                            <select name="shipping_address_type" class="form-control" required
                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                <option value="Home" {{ old('shipping_address_type') == 'Home' ? 'selected' : '' }}>Home</option>
                                                <option value="Work" {{ old('shipping_address_type') == 'Work' ? 'selected' : '' }}>Work</option>
                                                <option value="Other" {{ old('shipping_address_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="w-100 flex-1 border-btn place-order">Place Order</button>
                        </form>
                    </div>
                    <div class="col-lg-5 mt-4 mt-lg-0 ">
                       <div class="top-card-sticky">
                         <div class=" order-summary">
                            <h5 class="mb-3 border-bottom pb-2">Order Summary</h5>
                            <ul class="list-group list-group-flush mb-3 bg-transparent">
                                @foreach($cart as $item)
                                    @php $cart_total += $item['price'] * $item['quantity']; @endphp
                                    <li class="list-group-item d-flex align-items-center px-0 bg-transparent">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}"
                                            style="width:50px;height:50px;object-fit:cover;" class="rounded me-3 border">
                                        <div class="flex-grow-1">
                                            <div>
                                            <div class="fw-semibold block span-product_name">{{ $item['product_name'] }} </div>
                                            <small class="text-muted d-block">Size: {{ $item['size_name'] }}</small>
                                            <small class="text-muted d-block">Color: {{ $item['color_name'] }}  </small></div>
                                            </div>
                                                <div class="text-end ms-3">
                                                <div>₹{{ $item['price'] }}</div>
                                                <div class="span-product_name">x {{ $item['quantity'] }}</div>
                                            </div>
                                        </div>
                                       
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between align-items-center mb-2 border-top pt-3 mt-4">
                                <h5 class="fw-bold">Total</h5>
                                <h5 class="fw-bold fs-5"><small>₹</small>{{ $cart_total }}</h5>
                            </div>
                            <small class="text-muted">Taxes and shipping calculated at checkout.</small>
                        </div>
                       </div>
                    </div>
                </div>
            @else
               
                 <div class="cart-empty text-center py-5">
                    <i class="material-symbols-rounded text-muted" style="font-size: 48px;">shopping_cart</i>
                    <p class="text-muted mt-3">Your cart is empty</p>
                </div>
            @endif
        </div>
    </main>
    @section('script')
        @parent
        <script>
            function copyBillingToShipping() {
                const checkbox = document.getElementById('copyBilling');

                const billingName = document.getElementsByName('billing_name')[0].value;
                const billingPhone = document.getElementsByName('billing_phone')[0].value;
                const billingEmail = document.getElementsByName('billing_email')[0].value;
                const billingAddressLine1 = document.getElementsByName('billing_address_line1')[0].value;
                const billingAddressLine2 = document.getElementsByName('billing_address_line2')[0].value;
                const billingState = document.getElementById('billing_state').value;
                const billingCity = document.getElementById('billing_city').value;
                const billingPincode = document.getElementsByName('billing_pincode')[0].value;

                if (checkbox.checked) {
                    document.getElementsByName('shipping_name')[0].value = billingName;
                    document.getElementsByName('shipping_email')[0].value = billingEmail;
                    document.getElementsByName('shipping_phone')[0].value = billingPhone;
                    document.getElementsByName('shipping_address_line1')[0].value = billingAddressLine1;
                    document.getElementsByName('shipping_address_line2')[0].value = billingAddressLine2;
                    document.getElementsByName('shipping_pincode')[0].value = billingPincode;
                    // Set state first and trigger city population
                    const shippingStateSelect = document.getElementById('shipping_state');
                    const shippingCitySelect = document.getElementById('shipping_city');
                    shippingStateSelect.value = billingState;

                    handleStateChange('shipping_state', 'shipping_city');

                    // Wait for cities to populate before selecting the correct one
                    setTimeout(() => {
                        shippingCitySelect.value = billingCity;
                    }, 150);
                } else {
                    // Optional: Clear shipping fields when unchecked
                    document.getElementsByName('shipping_name')[0].value = '';
                    document.getElementsByName('shipping_email')[0].value = '';
                    document.getElementsByName('shipping_phone')[0].value = '';
                    document.getElementsByName('shipping_address_line1')[0].value = '';
                    document.getElementsByName('shipping_address_line2')[0].value = '';
                    document.getElementById('shipping_state').value = '';
                    document.getElementById('shipping_city').innerHTML = '<option value="">Select City</option>';
                    document.getElementById('shipping_city').disabled = true;
                }
            }

            // Keep this unchanged
            const stateCityMap = {
                'Maharashtra': ['Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik'],
                'Delhi': ['New Delhi', 'Delhi Cantt', 'Rohini', 'Dwarka'],
                'Karnataka': ['Bangalore', 'Mysore', 'Mangalore', 'Hubli'],
                'Tamil Nadu': ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli'],
                'West Bengal': ['Kolkata', 'Howrah', 'Durgapur', 'Siliguri'],
                'Gujarat': ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot'],
                'Uttar Pradesh': ['Lucknow', 'Kanpur', 'Ghaziabad', 'Agra'],
                'Rajasthan': ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota'],
                'Madhya Pradesh': ['Indore', 'Bhopal', 'Gwalior', 'Jabalpur'],
                'Punjab': ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala'],
                // Add more if needed
            };

            function handleStateChange(stateId, cityId) {
                const state = document.getElementById(stateId).value;
                const citySelect = document.getElementById(cityId);
                citySelect.innerHTML = '<option value="">Select City</option>';
                if (stateCityMap[state]) {
                    citySelect.disabled = false;
                    stateCityMap[state].forEach(function (city) {
                        const opt = document.createElement('option');
                        opt.value = city;
                        opt.textContent = city;
                        citySelect.appendChild(opt);
                    });
                } else {
                    citySelect.disabled = true;
                }
            }

            document.getElementById('shipping_state').addEventListener('change', function () {
                handleStateChange('shipping_state', 'shipping_city');
            });

            document.getElementById('billing_state').addEventListener('change', function () {
                handleStateChange('billing_state', 'billing_city');
            });
        </script>
    @endsection
@endsection