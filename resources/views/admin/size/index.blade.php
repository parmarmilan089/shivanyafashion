@extends('admin.layout.page')
@section('content')

<div class="container-fluid py-4">
  <h3 class="text-dark">Size List</h3>

  <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table id="size-table" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Size Name</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sizes as $size)
            <tr>
              <td>{{ $size->name }}</td>
              <td>
                <span class="badge bg-{{ $size->status == 'active' ? 'success' : 'secondary' }}">
                  {{ ucfirst($size->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.size.edit', $size->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.size.destroy', $size->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this size?')">Delete</button>
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
    $('#size-table').DataTable({
      responsive: true,
      language: {
        search: "Search Size:"
      }
    });
  });
</script>
@endpush