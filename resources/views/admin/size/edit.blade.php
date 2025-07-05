@extends('admin.layout.page')
@section('content')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Edit Size</h6>
        </div>
        <div class="card-body px-4 pt-2 pb-4">
          <form action="{{ route('admin.size.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 is-filled @error('name') is-invalid @enderror">
                  <label class="form-label">Size Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', $size->name) }}" required>
                </div>
                @error('name')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 @error('status') is-invalid @enderror">
                  <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $size->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $size->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                @error('status')
                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mt-3">
                <button type="submit" class="btn bg-gradient-dark text-white">Update Size</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection