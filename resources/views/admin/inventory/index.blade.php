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
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inventories as $product)
            <tr>
              <td>
                @php
                  $firstVariant = $product->variants->first();
                  $displayImage = null;
                  if ($firstVariant && $firstVariant->main_image) {
                    $displayImage = $firstVariant->main_image;
                  } elseif ($product->main_image) {
                    $displayImage = $product->main_image;
                  }
                @endphp
                @if($displayImage)
                  <img src="{{ asset('storage/' . $displayImage) }}" style="width: 70px; height: 50px; object-fit: cover;">
                @else
                  <span>No Image</span>
                @endif
              </td>
              <td>{{ Str::limit($product->name, 30) }}</td>
              <td>{{ $product->category->name ?? 'N/A' }}</td>
              <td>
                @php
                  $prices = $product->variants->pluck('price')->filter();
                  $minPrice = $prices->min();
                  $maxPrice = $prices->max();
                @endphp
                @if($minPrice && $maxPrice)
                  @if($minPrice == $maxPrice)
                    ₹{{ number_format($minPrice, 2) }}
                  @else
                    ₹{{ number_format($minPrice, 2) }} - ₹{{ number_format($maxPrice, 2) }}
                  @endif
                @else
                  ₹{{ number_format($product->price ?? 0, 2) }}
                @endif
              </td>
              <td>
                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($product->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.inventory.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <button type="button" class="btn btn-sm btn-danger delete-btn"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}">
                  Delete
                </button>
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
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $('#inventory-table').DataTable({
      responsive: true,
      language: {
        search: "Search Product:"
      }
    });

    // Delete confirmation with SweetAlert
    $('.delete-btn').on('click', function() {
      const productId = $(this).data('id');
      const productName = $(this).data('name');

      Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete "${productName}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Create and submit the delete form
          const form = $('<form>', {
            'method': 'POST',
            'action': `/admin/inventory/${productId}`
          });

          form.append($('<input>', {
            'type': 'hidden',
            'name': '_token',
            'value': '{{ csrf_token() }}'
          }));

          form.append($('<input>', {
            'type': 'hidden',
            'name': '_method',
            'value': 'DELETE'
          }));

          $('body').append(form);
          form.submit();
        }
      });
    });
  });
</script>
@endpush
