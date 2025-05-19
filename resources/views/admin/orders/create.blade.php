@extends('admin.layout.page')
@section('contect')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Place New Order</h6>
                    </div>
                    <div class="card-body px-4 pt-2 pb-4">
                        <form method="POST" action="{{ route('admin.order.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Select Sold On Platform</label>
                                    <div class="input-group input-group-outline my-2">
                                        <select name="sold_on" class="form-control" required>
                                            <option value="Meesho" {{ old('sold_on') == 'Meesho' ? 'selected' : '' }}>Meesho</option>
                                            <option value="Amazon" {{ old('sold_on') == 'Amazon' ? 'selected' : '' }}>Amazon</option>
                                        </select>
                                    </div>
                                    @error('sold_on')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="">Order Date</label>
                                    <div class="input-group input-group-outline my-2">
                                        <input type="date" name="purchase_date" class="form-control"
                                            value="{{ old('purchase_date') ? old('purchase_date') : \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                                    </div>
                                    @error('purchase_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="">Enter Sub Order Id</label>
                                    <div class="input-group input-group-outline my-2">
                                        <input type="text" name="sub_order_id" class="form-control"
                                            value="{{ old('sub_order_id') }}" placeholder="Enter Sub Order Id" required>
                                    </div>
                                    @error('sub_order_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="">Select Shipping</label>
                                    <div class="input-group input-group-outline my-2">
                                        <select name="shipping" class="form-control" required>
                                            <option disabled selected>Select Shipping</option>
                                            <option value="delhivery" {{ old('shipping') == 'delhivery' ? 'selected' : '' }}>Delhivery</option>
                                            <option value="ecomexpress" {{ old('shipping') == 'ecomexpress' ? 'selected' : '' }}>Ecom express</option>
                                            <option value="shadowfax" {{ old('shipping') == 'shadowfax' ? 'selected' : '' }}>Shadowfax</option>
                                            <option value="xpressbees" {{ old('shipping') == 'xpressbees' ? 'selected' : '' }}>Xpress bees</option>
                                        </select>
                                    </div>
                                    @error('shipping')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6>Product Selection</h6>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Select Product</label>
                                    <div class="input-group input-group-outline my-2">
                                        <select id="product-select" class="form-control select2">
                                            <option disabled selected>Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-name="{{ $product->name }}-{{ $product->platform_sku }}"
                                                    data-price="{{ $product->price }}"
                                                    data-base_price="{{ $product->base_price }}"
                                                    data-image="{{ asset('storage/' . $product->image) }}">
                                                    {{ $product->name }}-{{ $product->platform_sku }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>Qty</label>
                                    <div class="input-group input-group-outline my-2">
                                        <input type="number" id="product-qty" class="form-control" min="1" value="1">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>Price</label>
                                    <div class="input-group input-group-outline my-2">
                                        <input type="text" id="product-price" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>Subtotal</label>
                                    <div class="input-group input-group-outline my-2">
                                        <input type="text" id="product-subtotal" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="add-product">+
                                        Add Product</button>
                                </div>
                            </div>

                            @if ($errors->has('products'))
                                <small class="text-danger d-block mt-2">{{ $errors->first('products') }}</small>
                            @endif
                            @if ($errors->has('products.*.product_id'))
                                <small class="text-danger d-block mt-2">{{ $errors->first('products.*.product_id') }}</small>
                            @endif
                            @if ($errors->has('products.*.quantity'))
                                <small class="text-danger d-block mt-2">{{ $errors->first('products.*.quantity') }}</small>
                            @endif
                            @if ($errors->has('products.*.price'))
                                <small class="text-danger d-block mt-2">{{ $errors->first('products.*.price') }}</small>
                            @endif

                            <input type="hidden" name="total_amount" id="total_amount">
                            @error('total_amount')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror

                            <div class="col-12 mt-4">
                                <div class="card">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                            <h6 class="text-white text-capitalize ps-3">Product Summary</h6>
                                        </div>
                                    </div>
                                    <div class="card-body px-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Subtotal</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="product-summary-body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6>Total: ₹<span id="grand-total">0.00</span></h6>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn bg-gradient-dark text-white">Place Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
            let index = 0;
            let editingRow = null;

            function calculateTotal() {
                let total = 0;
                $('.subtotal').each(function () {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#grand-total').text(total.toFixed(2));
                $('#total_amount').val(total.toFixed(2));
            }

            function updateSubtotalPreview() {
                const selected = $('#product-select option:selected');
                const price = parseFloat(selected.data('price')) || 0;
                const qty = parseInt($('#product-qty').val()) || 1;
                $('#product-price').val(price.toFixed(2));
                $('#product-subtotal').val((price * qty).toFixed(2));
            }

            function resetForm() {
                $('#product-select').val(null).trigger('change');
                $('#product-qty').val(1);
                $('#product-price').val('');
                $('#product-subtotal').val('');
                $('#add-product').text('+ Add Product').removeClass('btn-warning').addClass('btn-outline-primary');
                editingRow = null;
            }

            function addProductRow(productId, name, image, price, qty, rowIndex = null, basePrice = 0) {
                console.log(basePrice,'basePrice');
                
                const subtotal = (price * qty).toFixed(2);
                const rowId = rowIndex !== null ? rowIndex : index;

                const rowHtml = `
                <tr data-index="${rowId}">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div><img src="${image}" class="avatar avatar-sm me-3 border-radius-lg" alt="${name}"></div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">${name}</h6>
                                <input type="hidden" name="products[${rowId}][product_id]" value="${productId}">
                            </div>
                        </div>
                    </td>
                    <td>
                        ₹<span class="view-price">${price.toFixed(2)}</span>
                        <input type="hidden" name="products[${rowId}][price]" value="${price}">
                        <input type="hidden" name="products[${rowId}][base_price]" value="${basePrice}">
                    </td>
                    <td class="text-center">
                        <input type="number" name="products[${rowId}][quantity]" class="form-control edit-qty text-center" min="1" value="${qty}">
                    </td>
                    <td class="text-center">
                        ₹<span class="view-subtotal">${subtotal}</span>
                        <input type="hidden" name="products[${rowId}][subtotal]" class="subtotal" value="${subtotal}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-secondary edit-row">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger remove-row">X</button>
                    </td>
                </tr>
            `;

                if (rowIndex !== null) {
                    $(`tr[data-index="${rowIndex}"]`).replaceWith(rowHtml);
                } else {
                    $('#product-summary-body').append(rowHtml);
                    index++;
                }

                calculateTotal();
            }

            $('#product-select, #product-qty').on('change keyup', updateSubtotalPreview);

            $('#add-product').on('click', function () {
                const selected = $('#product-select option:selected');
                const productId = selected.val();
                const name = selected.data('name');
                const price = parseFloat(selected.data('price'));
                const basePrice = parseFloat(selected.data('base_price')) || 0;
                console.log(basePrice,'basePrice1');
                
                const image = selected.data('image');
                const qty = parseInt($('#product-qty').val()) || 1;

                if (!productId || isNaN(price)) {
                    alert("Please select a valid product.");
                    return;
                }

                if (editingRow !== null) {
                    addProductRow(productId, name, image, price, qty, editingRow, basePrice);
                } else {
                    addProductRow(productId, name, image, price, qty, null, basePrice);
                }

                resetForm();
            });

            $(document).on('click', '.edit-row', function () {
                const $row = $(this).closest('tr');
                const rowId = $row.data('index');
                const productId = $row.find('input[name$="[product_id]"]').val();
                const price = parseFloat($row.find('input[name$="[price]"]').val());
                const qty = parseInt($row.find('input[name$="[quantity]"]').val());

                $('#product-select').val(productId).trigger('change');
                $('#product-qty').val(qty);
                $('#product-price').val(price.toFixed(2));
                $('#product-subtotal').val((price * qty).toFixed(2));

                editingRow = rowId;
                $('#add-product').text('Update Product').removeClass('btn-outline-primary').addClass('btn-warning');
            });

            $(document).on('input', '.edit-qty', function () {
                const $row = $(this).closest('tr');
                const qty = parseInt($(this).val()) || 1;
                const price = parseFloat($row.find('input[name$="[price]"]').val());
                const subtotal = (qty * price).toFixed(2);

                $row.find('.view-subtotal').text(subtotal);
                $row.find('input[name$="[subtotal]"]').val(subtotal);

                calculateTotal();
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            updateSubtotalPreview();
        });
    </script>
@endpush