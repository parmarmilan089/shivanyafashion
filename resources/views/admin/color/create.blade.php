@extends('admin.layout.page')
@section('contect')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Add New Color</h6>
        </div>
        <div class="card-body px-4 pt-2 pb-4">
          <form action="{{ route('admin.color.store') }}" method="POST">
            @csrf

            <div class="row">

              <!-- Color Name -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 {{ old('name') ? 'is-filled' : '' }} @error('name') is-invalid @enderror">
                  <label class="form-label">Color Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                @error('name')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Color Picker with Preview -->
              <div class="col-md-6">
                <label class="form-label">Select Color</label>
                <div class="d-flex align-items-center my-2">
                  <input type="color" name="code" id="colorPicker" class="form-control form-control-color me-2"
                    value="{{ old('code', '#000000') }}" style="width: 80px; height: 45px; padding: 2px;" required>
                </div>
                @error('code')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 @error('status') is-invalid @enderror">
                  <select name="status" class="form-control" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                @error('status')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Submit Button -->
              <div class="col-md-6 mt-3">
                <button type="submit" class="btn bg-gradient-dark text-white">Save Color</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection