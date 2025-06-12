@extends('admin.layout.page')

@section('contect')
<div class="container-fluid py-4">
  <h3 class="text-dark">Add Category</h3>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Enter Category Name <span class="text-danger">*</span></label>
            <div class="input-group input-group-outline my-2">
              <input type="text" name="name" class="form-control" placeholder="Enter Category Name"
                value="{{ old('name') }}" required onfocus="focused(this)" onfocusout="defocused(this)">
            </div>
            @error('name')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-md-6">
            <label>Select Category Type <span class="text-danger">*</span></label>
            <div class="input-group input-group-outline my-2">
              <select name="category_type" id="category_type" class="form-select" required
                onfocus="focused(this)" onfocusout="defocused(this)">
                <option value="">-- Select Type --</option>
                <option value="0" {{ old('category_type') == 0 ? 'selected' : '' }}>Main Category</option>
                <option value="1" {{ old('category_type') == 1 ? 'selected' : '' }}>Subcategory</option>
                <option value="2" {{ old('category_type') == 2 ? 'selected' : '' }}>Sub-Subcategory</option>
              </select>
            </div>
            @error('category_type')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>

        <div class="row mb-3" id="parentCategoryWrapper" style="display: none;">
          <div class="col-md-6">
            <label>Select Parent Category <span class="text-danger">*</span></label>
            <div class="input-group input-group-outline my-2">
              {{-- Main Category (used for Subcategory) --}}
              <select id="parent_main" class="form-select d-none" onfocus="focused(this)" onfocusout="defocused(this)">
                <option value="">-- Select Main Category --</option>
                @foreach ($mainCategories as $parent)
                  <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                  </option>
                @endforeach
              </select>

              {{-- Subcategory (used for Sub-Subcategory) --}}
              <select id="parent_sub" class="form-select d-none" onfocus="focused(this)" onfocusout="defocused(this)">
                <option value="">-- Select Subcategory --</option>
                @foreach ($subCategories as $parent)
                  <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                  </option>
                @endforeach
              </select>

              {{-- Hidden input for submitting actual value --}}
              <input type="hidden" name="parent_id" id="parent_id">
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
                  {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0"
                  {{ old('is_active') == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="inactive">Inactive</label>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">Create Category</button>
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
    handleCategoryType();

    $('#category_type').change(function () {
      handleCategoryType();
    });

    $('#parent_main, #parent_sub').change(function () {
      $('#parent_id').val($(this).val());
    });

    function handleCategoryType() {
      let type = $('#category_type').val();

      $('#parentCategoryWrapper').hide();
      $('#parent_main, #parent_sub').addClass('d-none');
      $('#parent_id').val('');

      if (type == "1") {
        $('#parentCategoryWrapper').show();
        $('#parent_main').removeClass('d-none').val('').trigger('change');
      } else if (type == "2") {
        $('#parentCategoryWrapper').show();
        $('#parent_sub').removeClass('d-none').val('').trigger('change');
      }
    }
  });
</script>
@endpush
