@extends('admin.layout.page')

@section('content')

<div class="container-fluid py-4">
  <h3 class="text-dark">Color List</h3>

  <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table id="color-table" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Color Code</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($colors as $color)
            <tr>
              <td>{{ $color->name }}</td>
              <td>
                <div class="d-flex align-items-center">
                  <span class="me-2">{{ $color->code }}</span>
                  <span style="background-color: {{ $color->code }}; width: 30px; height: 20px; display:inline-block; border:1px solid #ccc;"></span>
                </div>
              </td>
              <td>
                <span class="badge bg-{{ $color->status === 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($color->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.color.edit', $color->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this color?')">Delete</button>
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
    $('#color-table').DataTable({
      responsive: true,
      language: {
        search: "Search Color:"
      }
    });
  });
</script>
@endpush