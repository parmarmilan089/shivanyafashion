@extends('admin.layout.page')
@section('content')

<div class="container-fluid py-4">
  <h3 class="text-dark">Inventory List</h3>

  <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table id="inventory-table" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inventories as $product)
            <tr>
              <td>
                @if($product->main_image)
                  <img src="{{ asset('storage/' . $product->main_image) }}" style="width: 70px; height: 50px; object-fit: cover;">
                @else
                  <span>No Image</span>
                @endif
              </td>
              <td>{{ Str::limit($product->name, 30) }}</td>
              <td>{{ $product->category->name ?? 'N/A' }}</td>
              <td>₹{{ $product->price }}</td>
              <td>{{ $product->stock_qty }}</td>
              <td>
                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($product->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.inventory.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.inventory.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
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
    $('#inventory-table').DataTable({
      responsive: true,
      language: {
        search: "Search Product:"
      }
    });
  });
</script>
@endpush
