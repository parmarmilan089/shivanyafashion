@extends('front.layout.page')

@section('front-content')
<main class="main-content position-relative border-radius-lg first-section">
    <div class="container my-5">
        <h2 class="mb-4">Checkout</h2>
        @php $cart = session('cart', []); $cart_total = 0; @endphp
        @if(count($cart))
            <div class="row">
                <div class="col-lg-7">
                    <form method="POST" action="{{ route('checkout.process') }}">
                        @csrf
                        <div class="card mb-4 p-4">
                            <h5 class="mb-3">Billing Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="billing_name" class="form-control" required placeholder="Name" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="billing_phone" class="form-control" required placeholder="Phone" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Address</label>
                                    <div class="input-group input-group-outline my-0">
                                        <textarea name="billing_address" class="form-control" required placeholder="Address" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>State</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="billing_state" id="billing_state" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="">Select State</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Punjab">Punjab</option>
                                            <!-- Add more states as needed -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>City</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="billing_city" id="billing_city" class="form-control" required disabled onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Pincode</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="billing_pincode" class="form-control" required placeholder="Pincode" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="copyBilling" onclick="copyBillingToShipping()">
                            <label class="form-check-label" for="copyBilling">
                                Shipping details same as billing
                            </label>
                        </div>
                        <div class="card mb-4 p-4">
                            <h5 class="mb-3">Shipping Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="shipping_name" class="form-control" required placeholder="Name" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="email" name="shipping_email" class="form-control" required placeholder="Email" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="shipping_phone" class="form-control" required placeholder="Phone" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Alternate Phone</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="shipping_alt_phone" class="form-control" placeholder="Alternate Phone" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Address</label>
                                    <div class="input-group input-group-outline my-0">
                                        <textarea name="shipping_address" class="form-control" required placeholder="Address" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Landmark</label>
                                    <div class="input-group input-group-outline my-0">
                                        <input type="text" name="shipping_landmark" class="form-control" placeholder="Landmark" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>State</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="shipping_state" id="shipping_state" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="">Select State</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Punjab">Punjab</option>
                                            <!-- Add more states as needed -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>City</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="shipping_city" id="shipping_city" class="form-control" required disabled onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Country</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="shipping_country" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="India" selected>India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Address Type</label>
                                    <div class="input-group input-group-outline my-0">
                                        <select name="shipping_address_type" class="form-control" required onfocus="focused(this)" onfocusout="defocused(this)">
                                            <option value="Home">Home</option>
                                            <option value="Work">Work</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-dark w-100">Place Order</button>
                    </form>
                </div>
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="card p-4 shadow-sm order-summary">
                        <h5 class="mb-3 border-bottom pb-2">Order Summary</h5>
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cart as $item)
                                @php $cart_total += $item['price'] * $item['quantity']; @endphp
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" style="width:50px;height:50px;object-fit:cover;" class="rounded me-3 border">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">{{ $item['product_name'] }}</div>
                                        <small class="text-muted">Size: {{ $item['size_name'] }}, Color: {{ $item['color_name'] }}</small>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div>₹{{ $item['price'] }}</div>
                                        <div class="text-muted">x {{ $item['quantity'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5">₹{{ $cart_total }}</span>
                        </div>
                        <small class="text-muted">Taxes and shipping calculated at checkout.</small>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">Your cart is empty.</div>
        @endif
    </div>
</main>
@section('script')
@parent
<script>
function copyBillingToShipping() {
    if(document.getElementById('copyBilling').checked) {
        document.getElementsByName('shipping_name')[0].value = document.getElementsByName('billing_name')[0].value;
        document.getElementsByName('shipping_phone')[0].value = document.getElementsByName('billing_phone')[0].value;
        document.getElementsByName('shipping_address')[0].value = document.getElementsByName('billing_address')[0].value;
        document.getElementsByName('shipping_city')[0].value = document.getElementsByName('billing_city')[0].value;
        document.getElementsByName('shipping_state')[0].value = document.getElementsByName('billing_state')[0].value;
        document.getElementsByName('shipping_pincode')[0].value = document.getElementsByName('billing_pincode')[0].value;
    }
}

// Extend stateCityMap and dynamic logic for billing as well
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
    // Add more as needed
};

function handleStateChange(stateId, cityId) {
    const state = document.getElementById(stateId).value;
    const citySelect = document.getElementById(cityId);
    citySelect.innerHTML = '<option value="">Select City</option>';
    if(stateCityMap[state]) {
        citySelect.disabled = false;
        stateCityMap[state].forEach(function(city) {
            const opt = document.createElement('option');
            opt.value = city;
            opt.textContent = city;
            citySelect.appendChild(opt);
        });
    } else {
        citySelect.disabled = true;
    }
}
document.getElementById('shipping_state').addEventListener('change', function() {
    handleStateChange('shipping_state', 'shipping_city');
});
document.getElementById('billing_state').addEventListener('change', function() {
    handleStateChange('billing_state', 'billing_city');
});
</script>
@endsection
@endsection
