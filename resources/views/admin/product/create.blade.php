@extends('admin.layout.page')
@section('contect')
  <div class="container-fluid py-4">
    <div class="row">
    <div class="col-12">
      <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Add New Product</h6>
      </div>
      <div class="card-body px-4 pt-2 pb-4">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6">
          <div
            class="input-group input-group-outline my-2 {{ old('name') ? 'is-filled' : '' }} @error('name') is-invalid @enderror">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>
          @error('name')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>

          <div class="col-md-6">
          <div
            class="input-group input-group-outline my-2 {{ old('sku') ? 'is-filled' : '' }} @error('sku') is-invalid @enderror">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
          </div>
          @error('sku')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-6">
          <div
            class="input-group input-group-outline my-2 {{ old('base_price') ? 'is-filled' : '' }} @error('base_price') is-invalid @enderror">
            <label class="form-label">Base Price</label>
            <input type="number" name="base_price" class="form-control" value="{{ old('base_price') }}" required>
          </div>
          @error('base_price')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-6">
          <div
            class="input-group input-group-outline my-2 {{ old('price') ? 'is-filled' : '' }} @error('price') is-invalid @enderror">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
          </div>
          @error('price')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>


          <div class="col-md-6">
          <div
            class="input-group input-group-outline my-2 {{ old('seller_name') ? 'is-filled' : '' }} @error('seller_name') is-invalid @enderror">
            <label class="form-label">Seller Name</label>
            <input type="text" name="seller_name" class="form-control" value="{{ old('seller_name') }}" required>
          </div>
          @error('seller_name')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>

          <div class="col-md-6">
          <div class="input-group input-group-outline my-2 @error('status') is-invalid @enderror">
            <select name="status" class="form-control" required>
            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Select status</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="deactive" {{ old('status') == 'deactive' ? 'selected' : '' }}>Deactive</option>
            </select>
          </div>
          @error('status')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>

          <div class="col-md-6">

          <div class="input-group input-group-outline my-2 @error('selling_platform') is-invalid @enderror">
            <select name="selling_platform" class="form-control" required>
            <option value="" disabled {{ old('selling_platform') ? '' : 'selected' }}>Select Selling Platform
            </option>
            <option value="Meesho" {{ old('selling_platform') == 'Meesho' ? 'selected' : '' }}>Meesho</option>
            <option value="Amazon" {{ old('selling_platform') == 'Amazon' ? 'selected' : '' }}>Amazon</option>
            </select>
          </div>
          @error('selling_platform')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror
          </div>
          <div class="col-md-12 mt-2">
          <label class="text-sm text-dark mb-1">Product Image</label>
          <div class="input-group input-group-outline my-2 @error('image') is-invalid @enderror">
            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)"
            required>
          </div>
          @error('image')
        <div class="text-danger text-sm mt-1">{{ $message }}</div>
      @enderror

          <div class="mt-2">
            <img id="imagePreview" src="#" alt="Preview" style="max-height: 150px; display: none;"
            class="border rounded">
          </div>
          </div>
          <div class="col-md-6 mt-2">
          <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
          </div>

        </form>


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