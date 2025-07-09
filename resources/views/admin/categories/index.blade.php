@extends('admin.layout.page')

@section('content')
  <div class="container-fluid py-4">
    <h3 class="text-dark">Category List</h3>

    <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
      <table id="category-table" class="table align-items-center mb-0">
        <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Level</th> {{-- 0 = Category • 1 = Sub • 2 = Sub-Sub --}}
          <th>Parent</th>
          <th>Status</th>
          <th class="text-center">Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($categories as $category)
        <tr>
        <td>
        @if($category->image)
        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="50">
      @endif
        </td>
        <td>{{ Str::limit($category->name, 30) }}</td>

        <td>
        @php $levels = ['Category', 'Subcategory', 'Sub-Subcategory']; @endphp
        <span class="badge bg-info">{{ $levels[$category->category_type] ?? '—' }}</span>
        </td>

        <td>{{ optional($category->parent)->name ?? '—' }}</td>

        <td>
        <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
          {{ $category->is_active ? 'Active' : 'Inactive' }}
        </span>
        </td>

        <td class="text-center">
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
          Edit
        </a>

        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
          style="display:inline-block;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
          Delete
          </button>
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
    $('#category-table').DataTable({
      responsive: true,
      language: {
      search: "Search Category:"
      },
      columnDefs: [
      { orderable: false, targets: 4 }   // disable ordering on “Actions”
      ]
    });
    });
  </script>
@endpush