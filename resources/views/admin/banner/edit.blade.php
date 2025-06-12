@extends('admin.layout.page')

@section('contect')
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Edit Banner</h6>
          </div>
          <div class="card-body px-4 pt-2 pb-4">
            <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row">
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2 {{ old('title', $banner->title) ? 'is-filled' : '' }}">
                    <label class="form-label">Banner Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
                  </div>
                  @error('title')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2 {{ old('subtitle', $banner->subtitle) ? 'is-filled' : '' }}">
                    <label class="form-label">Banner Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}" required>
                  </div>
                  @error('subtitle')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select name="status" class="form-control" required>
                      <option value="1" {{ $banner->status == '1' ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ $banner->status == '0' ? 'selected' : '' }}>Deactive</option>
                    </select>
                  </div>
                  @error('status')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <div class="col-md-12 mt-2">
                  <label class="text-sm text-dark mb-1">Banner Image</label>
                  <div class="input-group input-group-outline my-2 @error('image') is-invalid @enderror">
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                  </div>
                  @error('image')
                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                  @enderror

                  <div class="mt-2">
                    @if($banner->image)
                      <img id="imagePreview" src="{{ asset('storage/' . $banner->image) }}" alt="Preview" style="max-height: 150px;" class="border rounded">
                    @else
                      <img id="imagePreview" src="#" alt="Preview" style="max-height: 150px; display: none;" class="border rounded">
                    @endif
                  </div>
                </div>

                <div class="col-md-6 mt-4">
                  <button type="submit" class="btn bg-gradient-dark text-white">Update Banner</button>
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
