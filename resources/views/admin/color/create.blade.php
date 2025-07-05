@extends('admin.layout.page')
@section('content')


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
          <div
            class="input-group input-group-outline my-2 {{ old('name') ? 'is-filled' : '' }} @error('name') is-invalid @enderror">
            <label class="form-label">Color Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>
          @error('name')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-6">
          <!-- <label for="d">Status</label> -->
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

          <!-- Enhanced Color Picker UI -->
          <div class="col-md-6">
          <div class="my-2">
            <label class="form-label d-block mb-1">Select Color</label>
            <div class="d-flex align-items-center gap-3">
            <input type="color" name="code" id="colorPicker" class="form-control-color border-0 p-0"
              value="{{ old('code', '#000000') }}"
              style="width: 60px; height: 60px; cursor: pointer;border-radius: 50%;" required>
            <div id="colorPreview" class="d-none"
              style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #ccc; background-color: {{ old('code', '#000000') }}">
            </div>

            <span class="text-muted" id="colorCodeText">{{ old('code', '#000000') }}</span>
            </div>
          </div>
          @error('code')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>

          <!-- Status -->


          <!-- Submit Button -->
          <div class="col-md-6">
          </div>
          <div class="col-md-6">
          <button type="submit" class="btn bg-gradient-dark text-white">Save Color</button>
          </div>

        </div>
        </form>
      </div>
      </div>
    </div>
    </div>
  </div>

  <script>
    const picker = document.getElementById('colorPicker');
    const preview = document.getElementById('colorPreview');
    const colorCodeText = document.getElementById('colorCodeText');

    picker.addEventListener('input', function () {
    const selectedColor = this.value;
    preview.style.backgroundColor = selectedColor;
    colorCodeText.textContent = selectedColor;
    });
  </script>

@endsection