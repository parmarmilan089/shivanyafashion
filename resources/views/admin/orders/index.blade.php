@extends('admin.layout.page')
@section('contect')
  <style>
    .pagination {
    justify-content: center;
    margin-top: 1rem;
    }
  </style>
  <div class="container-fluid py-4">
    <h3 class="text-dark">Order List</h3>

    <!-- Filter Section -->
    <div class="card mb-4">
    <div class="card-body py-3">
      <form method="GET" action="{{ route('admin.order') }}" class="row align-items-end">
      <div class="col-md-3">
        <label for="platform" class="form-label mb-1">Filter by Platform</label>
        <select name="platform" id="platform" class="form-select form-select-sm">
        <option value="">All Platforms</option>
        <option value="Amazon" {{ request('platform') == 'Amazon' ? 'selected' : '' }}>Amazon</option>
        <option value="Meesho" {{ request('platform') == 'Meesho' ? 'selected' : '' }}>Meesho</option>
        </select>
      </div>

      <div class="col-md-3">
        <label for="order_status" class="form-label mb-1">Filter by Status</label>
        <select name="order_status" id="order_status" class="form-select form-select-sm">
        <option value="">All Status</option>
        <option value="Pending" {{ request('order_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Shipped" {{ request('order_status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
        <option value="Delivered" {{ request('order_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
        <option value="Returned" {{ request('order_status') == 'Returned' ? 'selected' : '' }}>Returned</option>
        </select>
      </div>

      <div class="col-md-3">
        <label for="from_date" class="form-label mb-1">From Date</label>
        <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"
        value="{{ request('from_date') }}">
      </div>

      <div class="col-md-3">
        <label for="to_date" class="form-label mb-1">To Date</label>
        <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
        value="{{ request('to_date') }}">
      </div>

      <div class="col-md-12 text-end mt-3">
        <button type="submit" class="btn btn-sm btn-primary">Apply Filters</button>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-sm btn-success ms-2">Export
        Excel</a>
        <a href="{{ route('admin.order') }}" class="btn btn-sm btn-outline-danger ms-2">Reset</a>
      </div>
      </form>
    </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
      <table id="order-table" class="table align-items-center mb-0">
        <thead>
        <tr>
          <th>Order ID</th>
          <th>Products</th>
          <th>Purchase Date</th>
          <th>Total Amount</th>
          <th>Shipping</th>
          <th>Payment</th>
          <th>Sub Order Id</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
        <td>{{ $order->id }}</td>
        <td>
        <div class="d-flex flex-column gap-2 mt-2">
          @foreach($order->orderProducts as $op)
        @php $product = $op->product; @endphp
        @if($product)
        <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
        style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
        <div>
        <div style="font-size: 0.85rem;">{{ Str::limit($product->name, 30) }}</div>
        <small class="text-muted">SKU: {{ $product->platform_sku }}</small><br>
        <small class="text-muted">Size: {{ $op->size ?? 'N/A' }}</small> {{-- SIZE FROM ORDER_PRODUCTS
        --}}
        </div>
        </div>
        @endif
        </div>
        @if($op->quantity > 1)
        <span class="badge bg-danger mt-2">{{ $op->quantity }} Product(s)</span>
        @else
        <span class="badge bg-secondary mt-2">{{ $op->quantity }} Product(s)</span>
        @endif
      @endforeach
        </td>
        <td>{{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</td>
        <td>₹{{ number_format($order->total_amount, 2) }}</td>
        <td>{{ $order->shipping}}</td>
        <td>
        @if($order->payment_status)
        <span class="badge bg-success mt-2">Received</span>
      @else
        <span class="badge bg-danger mt-2">Pending</span>
      @endif
        <td>{{ $order->sub_order_id}}</td>
        <td>
        <div class="d-flex flex-column gap-2">
          {{-- Order Status Dropdown --}}
          <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST"
          id="status-form-{{ $order->id }}">
          @csrf
          @method('PATCH')

          <select name="order_status" onchange="toggleShippingInput(this, {{ $order->id }})"
          class="form-select form-select-sm">
          <option value="RTO-Return" {{ $order->order_status == 'RTO-Return' ? 'selected' : '' }}>RTO-Return
          </option>
          <option value="Wrong-RTO-Return" {{ $order->order_status == 'Wrong-RTO-Return' ? 'selected' : '' }}>
          Wrong-RTO-Return
          </option>
          <option value="Wrong-Return" {{ $order->order_status == 'Wrong-Return' ? 'selected' : '' }}>
          Wrong-Return
          </option>
          <option value="Missing-Return" {{ $order->order_status == 'Missing-Return' ? 'selected' : '' }}>
          Missing-Return
          </option>
          <option value="Delivered" {{ $order->order_status == 'Delivered' ? 'selected' : '' }}>Delivered
          </option>
          <option value="Returned" {{ $order->order_status == 'Returned' ? 'selected' : '' }}>Returned
          </option>
          </select>

          <div class="mt-2 shipping-charge-group" id="shipping-group-{{ $order->id }}"
          style="display: {{ $order->order_status == 'Returned' ? 'block' : 'none' }};">

          <div class="input-group input-group-outline my-2">
          <input type="number" step="0.01" name="return_shipping_charge" class="form-control"
            placeholder="Enter Return Shipping Charge" value="{{ $order->return_charges ?? '' }}"
            onfocus="focused(this)" onfocusout="defocused(this)">
          </div>
          <button type="submit" class="btn btn-sm btn-primary mt-2">Update Status</button>
          </div>
          </form>

          {{-- Action Buttons --}}
          <div class="d-flex gap-1 mt-1">
          <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-success">View</a>
          <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger"
          onclick="return confirm('Delete this order?')">Delete</button>
          </form>
          </div>
        </div>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
    </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    $(document).ready(function () {
    let table = $('#order-table').DataTable({
      responsive: true,
      language: {
      search: "Search Orders:",
      emptyTable: "No orders found"
      },
      info: true,
      lengthChange: true,
      lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
      order: [[0, 'desc']] // 👈 Sort by first column (Order ID) descending
    });

    $('#order-table_filter').css('display', 'block');
    });
  </script>
  <script>
    function toggleShippingInput(select, orderId) {
    const shippingGroup = document.getElementById('shipping-group-' + orderId);
    const form = document.getElementById('status-form-' + orderId);

    if (select.value === 'Returned' || select.value === 'Wrong-Return' || select.value === 'Missing-Return') {
      shippingGroup.style.display = 'block';
    } else {
      shippingGroup.style.display = 'none';
      form.submit();
    }
    }
  </script>
@endpush