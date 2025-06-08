@extends('admin.layout.page')
@section('contect')

  <div class="container-fluid py-4">
    <h3 class="text-dark">Product List</h3>

    <div class="card">
    <div class="card-body px-0  pb-2">
      <div class="table-responsive p-0">
      <table id="product-table" class="table align-items-center mb-0">
        <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>SKU</th>
          <th>Price</th>
          <th>Platform</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
        <td>
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image"
          style="width: 50px; height: 50px; object-fit: cover;">
        </a>
      @else
        <span>No Image</span>
      @endif
        </td>
        <td>{{ Str::limit($product->name, 20) }}</td>
        <td>{{ $product->platform_sku }}</td>
        <td>₹{{ $product->price }}</td>
        <td>{{ $product->selling_platform }}</td>
        <td>
        <span
          class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($product->status) }}</span>
        </td>
        <td>
        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
          style="display:inline-block;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger"
          onclick="return confirm('Delete this product?')">Delete</button>
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
    $('#product-table').DataTable({
      responsive: true,
      language: {
      search: "Search Product:"
      }
    });
    });
  </script>
@endpush