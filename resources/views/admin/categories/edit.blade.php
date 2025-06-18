@extends('admin.layout.page')

@section('contect')
<div class="container-fluid py-4">
  <h3 class="text-dark">Edit Category</h3>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="name">Category Name <span class="text-danger">*</span></label>
            <div class="input-group input-group-outline my-2">
              <input type="text" name="name" class="form-control"
                     value="{{ old('name', $category->name) }}" required
                     placeholder="Enter Category Name" onfocus="focused(this)" onfocusout="defocused(this)">
            </div>
            @error('name')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="category_type">Category Type <span class="text-danger">*</span></label>
            <div class="input-group input-group-outline my-2">
              <select name="category_type" id="category_type" class="form-select" required
                      onfocus="focused(this)" onfocusout="defocused(this)">
                <option value="">-- Select Type --</option>
                <option value="0" {{ old('category_type', $category->category_type) == 0 ? 'selected' : '' }}>Main Category</option>
                <option value="1" {{ old('category_type', $category->category_type) == 1 ? 'selected' : '' }}>Subcategory</option>
                <option value="2" {{ old('category_type', $category->category_type) == 2 ? 'selected' : '' }}>Sub-Subcategory</option>
              </select>
            </div>
            @error('category_type')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="row mb-3" id="parentCategoryWrapper" style="display: none;">
          <div class="col-md-6">
            <label for="parent_id">Parent Category</label>
            <div class="input-group input-group-outline my-2">
              <select name="parent_id" id="parent_id" class="form-select"
                      onfocus="focused(this)" onfocusout="defocused(this)">
                <option value="">-- Select Parent --</option>
                @foreach ($parentCategories as $parent)
                  <option value="{{ $parent->id }}"
                    {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                  </option>
                @endforeach
              </select>
            </div>
            @error('parent_id')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Status</label>
            <div class="input-group input-group-outline my-2">
              <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="is_active" id="active" value="1"
                  {{ old('is_active', $category->is_active) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0"
                  {{ old('is_active', $category->is_active) == 0 ? 'checked' : '' }}>
                <label class="form-check-label" for="inactive">Inactive</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Category Image</label>
            <div class="input-group input-group-outline my-2">
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            @error('image')
              <small class="text-danger">{{ $message }}</small>
            @enderror

            @if ($category->image)
              <div class="mt-2">
                <label>Current Image:</label><br>
                <img src="{{ asset($category->image) }}" alt="Current Image" width="100">
              </div>
            @endif
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">Update Category</button>
          <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    function toggleParentCategory() {
      const selectedType = $('#category_type').val();
      if (selectedType === "1" || selectedType === "2") {
        $('#parentCategoryWrapper').show();
      } else {
        $('#parentCategoryWrapper').hide();
        $('#parent_id').val('');
      }
    }

    toggleParentCategory();
    $('#category_type').change(toggleParentCategory);
  });
</script>
@endpush