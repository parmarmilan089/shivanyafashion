@extends('admin.layout.page')
@section('contect')

<div class="container-fluid py-4">
  <h3 class="text-dark">Banner List</h3>

  <div class="card">
    <div class="card-body px-0 pb-2">
      <div class="table-responsive p-0">
        <table id="banner-table" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Subtitle</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($banners as $banner)
            <tr>
              <td>
                @if($banner->image)
                  <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image"
                    style="width: 80px; height: 50px; object-fit: cover;">
                @else
                  <span>No Image</span>
                @endif
              </td>
              <td>{{ Str::limit($banner->title, 30) }}</td>
              <td>{{ Str::limit($banner->subtitle, 40) }}</td>
              <td>
                <span class="badge bg-{{ $banner->status ? 'success' : 'secondary' }}">
                  {{ $banner->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this banner?')">Delete</button>
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
    $('#banner-table').DataTable({
      responsive: true,
      language: {
        search: "Search Banner:"
      }
    });
  });
</script>
@endpush
