@extends('admin.layout.page')
@section('contect')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Edit Product</h6>
          </div>

          <div class="card-body px-4 pt-2 pb-4">
            <div class="row">

              <!-- Product Name -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 is-filled">
                  <label class="form-label">Product Name</label>
                  <input type="text" name="name" class="form-control" value="{{ $inventory->name }}" required>
                </div>
              </div>

              <!-- SKU -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2 is-filled">
                  <label class="form-label">SKU</label>
                  <input type="text" name="sku" class="form-control" value="{{ $inventory->sku }}" required>
                </div>
              </div>

              <!-- Category -->
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Category</label>
                  <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                      <option value="{{ $cat->id }}" {{ $inventory->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <!-- Tags -->
              <div class="col-md-6">
                <div class="my-2">
                  <label class="form-label">Tags</label>
                  <input type="text" name="tags" id="tag-input" value="{{ $inventory->tags }}" />
                </div>
              </div>

              <!-- Price & Sale Price -->
              <div class="col-md-3">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Price</label>
                  <input type="number" name="price" step="0.01" class="form-control" value="{{ $inventory->price }}" required>
                </div>
              </div>

              <div class="col-md-3">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Sale Price</label>
                  <input type="number" name="sale_price" step="0.01" class="form-control" value="{{ $inventory->sale_price }}">
                </div>
              </div>

              <!-- Stock Qty -->
              <div class="col-md-3">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Stock Quantity</label>
                  <input type="number" name="stock_qty" class="form-control" value="{{ $inventory->stock_qty }}" required>
                </div>
              </div>

              <!-- Stock Status -->
              <div class="col-md-3">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Stock Status</label>
                  <select name="stock_status" class="form-control">
                    <option value="in_stock" {{ $inventory->stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="out_of_stock" {{ $inventory->stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="pre_order" {{ $inventory->stock_status == 'pre_order' ? 'selected' : '' }}>Pre-order</option>
                  </select>
                </div>
              </div>

              <!-- Colors -->
              <div class="col-md-6 mt-2">
                <label class="form-label">Colors</label>
                <select name="colors[]" class="form-control" multiple>
                  @foreach ($colors as $color)
                    <option value="{{ $color->id }}" {{ in_array($color->id, (array) $inventory->colors) ? 'selected' : '' }}>
                      {{ $color->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Sizes -->
              <div class="col-md-6 mt-2">
                <label class="form-label">Sizes</label>
                <select name="sizes[]" class="form-control" multiple>
                  @foreach ($sizes as $size)
                    <option value="{{ $size->id }}" {{ in_array($size->id, (array) $inventory->sizes) ? 'selected' : '' }}>
                      {{ $size->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Dropdown Fields -->
              <div class="col-md-3 mt-3">
                <label class="form-label">Fabric</label>
                <select name="fabric" class="form-control">
                  <option value="">Select</option>
                  <option value="cotton" {{ $inventory->fabric == 'cotton' ? 'selected' : '' }}>Cotton</option>
                  <option value="rayon" {{ $inventory->fabric == 'rayon' ? 'selected' : '' }}>Rayon</option>
                  <option value="silk" {{ $inventory->fabric == 'silk' ? 'selected' : '' }}>Silk</option>
                  <option value="georgette" {{ $inventory->fabric == 'georgette' ? 'selected' : '' }}>Georgette</option>
                </select>
              </div>

              <div class="col-md-3 mt-3">
                <label class="form-label">Fit</label>
                <select name="fit" class="form-control">
                  <option value="">Select</option>
                  <option value="regular" {{ $inventory->fit == 'regular' ? 'selected' : '' }}>Regular</option>
                  <option value="slim" {{ $inventory->fit == 'slim' ? 'selected' : '' }}>Slim</option>
                  <option value="a-line" {{ $inventory->fit == 'a-line' ? 'selected' : '' }}>A-line</option>
                  <option value="flared" {{ $inventory->fit == 'flared' ? 'selected' : '' }}>Flared</option>
                </select>
              </div>

              <div class="col-md-3 mt-3">
                <label class="form-label">Top Length</label>
                <select name="top_length" class="form-control">
                  <option value="">Select</option>
                  <option value="short" {{ $inventory->top_length == 'short' ? 'selected' : '' }}>Short</option>
                  <option value="knee-length" {{ $inventory->top_length == 'knee-length' ? 'selected' : '' }}>Knee Length</option>
                  <option value="long" {{ $inventory->top_length == 'long' ? 'selected' : '' }}>Long</option>
                </select>
              </div>

              <div class="col-md-3 mt-3">
                <label class="form-label">Pattern</label>
                <select name="pattern" class="form-control">
                  <option value="">Select</option>
                  <option value="solid" {{ $inventory->pattern == 'solid' ? 'selected' : '' }}>Solid</option>
                  <option value="printed" {{ $inventory->pattern == 'printed' ? 'selected' : '' }}>Printed</option>
                  <option value="embroidered" {{ $inventory->pattern == 'embroidered' ? 'selected' : '' }}>Embroidered</option>
                </select>
              </div>

              <!-- Images -->
              <div class="col-md-6 mt-3">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                @if ($inventory->main_image)
                  <img src="{{ asset('storage/' . $inventory->main_image) }}" style="max-height: 100px;" class="mt-2">
                @endif
              </div>

              <div class="col-md-6 mt-3">
                <label class="form-label">Gallery Images</label>
                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
                @if ($inventory->gallery_images)
                  @foreach (json_decode($inventory->gallery_images) as $img)
                    <img src="{{ asset('storage/' . $img) }}" style="max-height: 80px;" class="me-2 mt-2">
                  @endforeach
                @endif
              </div>

              <!-- SEO Fields -->
              <div class="col-md-6 mt-3">
                <div class="input-group input-group-outline my-2 is-filled">
                  <label class="form-label">Meta Title</label>
                  <input type="text" name="meta_title" class="form-control" value="{{ $inventory->meta_title }}">
                </div>
              </div>

              <div class="col-md-6 mt-3">
                <div class="input-group input-group-outline my-2 is-filled">
                  <label class="form-label">Meta Keywords</label>
                  <input type="text" name="meta_keywords" class="form-control" value="{{ $inventory->meta_keywords }}">
                </div>
              </div>

              <div class="col-md-12">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Meta Description</label>
                  <textarea name="meta_description" class="form-control" rows="2">{{ $inventory->meta_description }}</textarea>
                </div>
              </div>

              <!-- Status -->
              <div class="col-md-6 mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                  <option value="active" {{ $inventory->status == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ $inventory->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  <option value="draft" {{ $inventory->status == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
              </div>

              <!-- Submit -->
              <div class="col-md-6 mt-4">
                <button type="submit" class="btn bg-gradient-dark text-white w-100">Update Product</button>
              </div>

            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
  new Choices('#tag-input', {
    removeItemButton: true,
    delimiter: ',',
    placeholderValue: 'Enter tags...',
    duplicateItemsAllowed: false
  });
</script>
@endpush