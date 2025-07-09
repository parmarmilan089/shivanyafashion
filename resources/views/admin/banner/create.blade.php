@extends('admin.layout.page')
@section('content')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Add New Banner</h6>
        </div>
        <div class="card-body px-4 pt-2 pb-4">
          <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 {{ old('title') ? 'is-filled' : '' }} @error('title') is-invalid @enderror">
                  <label class="form-label">Banner Title</label>
                  <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                @error('title')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 {{ old('subtitle') ? 'is-filled' : '' }} @error('subtitle') is-invalid @enderror">
                  <label class="form-label">Banner Subtitle</label>
                  <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" required>
                </div>
                @error('subtitle')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 @error('status') is-invalid @enderror">
                    <select name="status" class="form-control" required>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Deactive</option>
                  </select>
                </div>
                @error('status')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12 mt-2">
                <label class="text-sm text-dark mb-1">Banner Image</label>
                <div class="input-group input-group-outline my-2 @error('image') is-invalid @enderror">
                  <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                </div>
                @error('image')
                  <div class="text-danger text-sm mt-1">{{ $message }}</div>
                @enderror

                <div class="mt-2">
                  <img id="imagePreview" src="#" alt="Preview" style="max-height: 150px; display: none;" class="border rounded">
                </div>
              </div>

              <div class="col-md-6 mt-3">
                <button type="submit" class="btn bg-gradient-dark text-white">Save Banner</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function previewImage(event) {
  const input = event.target;
  const preview = document.getElementById('imagePreview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

@endsection
