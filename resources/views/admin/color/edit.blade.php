@extends('admin.layout.page')
@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Edit Color</h6>
        </div>
        <div class="card-body px-4 pt-2 pb-4">
          <form action="{{ route('admin.color.update', $color->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

              <!-- Color Name -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 is-filled @error('name') is-invalid @enderror">
                  <label class="form-label">Color Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', $color->name) }}" required>
                </div>
                @error('name')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 @error('status') is-invalid @enderror">
                  <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $color->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $color->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                @error('status')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Enhanced Color Picker -->
              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label d-block mb-1">Select Color</label>
                  <div class="d-flex align-items-center gap-3">
                    <input type="color" name="code" id="colorPicker" class="form-control-color p-0"
                      value="{{ old('code', $color->code) }}"
                      style="width: 50px; height: 50px; cursor: pointer; border:5px solid rgb(148, 148, 148)" required>

                    <div id="colorPreview"
                      style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #ccc; background-color: {{ old('code', $color->code) }}">
                    </div>

                    <span class="text-muted" id="colorCodeText">{{ old('code', $color->code) }}</span>
                  </div>
                </div>
                @error('code')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <!-- Spacer -->
              <div class="col-md-6"></div>

              <!-- Submit Button -->
              <div class="col-md-6 mt-3">
                <button type="submit" class="btn bg-gradient-dark text-white">Update Color</button>
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