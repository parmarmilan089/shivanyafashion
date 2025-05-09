@extends('admin.layout.page')
@section('contect')

<div class="container-fluid py-4">
  <h3 class="text-dark">Order List</h3>

  <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table id="order-table" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Platform</th>
              <th>Order Date</th>
              <th>Total Amount</th>
              <th>Status</th>
              <th>Products</th> <!-- Added column for products count -->
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>
              <td>#{{ $order->id }}</td>
              <td>{{ $order->sold_on }}</td>
              <td>{{ \Carbon\Carbon::parse($order->purchase_date)->format('d M Y') }}</td>
              <td>₹{{ number_format($order->total_amount, 2) }}</td>
              <td>
                <span class="badge bg-success">{{ ucfirst($order->order_status) }}</span>
              </td>
              <td>
                <span class="badge bg-info">{{ $order->product->count() }} Product(s)</span> <!-- Show the number of products -->
              </td>
              <td>
                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this order?')">Delete</button>
                </form>
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
    $('#order-table').DataTable({
      responsive: true,
      language: {
        search: "Search Order:"
      }
    });
  });
</script>
@endpush