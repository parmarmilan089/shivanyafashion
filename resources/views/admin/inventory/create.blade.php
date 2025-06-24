@extends('admin.layout.page')
@section('contect')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Add New Product</h6>
                        </div>

                        <div class="card-body px-4 pt-2 pb-4">
                            <div class="row">
                                <!-- Product Name -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>

                                <!-- SKU -->
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="my-2">
                                        <label class="form-label d-block">Category</label>
                                        <select name="category_id" id="category-select" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="col-md-6">
                                    <div class="my-2">
                                        <label class="form-label">Tags</label>
                                        <input type="text" name="tags" id="tag-input" placeholder="Type and press Enter" />
                                    </div>
                                </div>

                                <!-- General Price & Stock Info -->
                                <div class="col-md-3">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Price</label>
                                        <input type="number" name="price" step="0.01" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Sale Price</label>
                                        <input type="number" name="sale_price" step="0.01" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock_qty" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group-outline my-2">
                                        <select name="stock_status" class="form-control" id="stock_status">
                                            <option value="in_stock">In Stock</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                            <option value="pre_order">Pre-order</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Colors -->
                                <div class="col-md-6">
                                    <label class="form-label mt-2">Colors</label>
                                    <select name="colors[]" class="form-control" multiple>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sizes -->
                                <div class="col-md-6">
                                    <label class="form-label mt-2">Sizes</label>
                                    <select name="sizes[]" class="form-control" multiple>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Fabric, Fit, Length, Pattern -->
                                <div class="col-md-3 mt-3">
                                    <label class="form-label">Fabric</label>
                                    <select name="fabric" class="form-control">
                                        <option value="">Select</option>
                                        <option value="cotton">Cotton</option>
                                        <option value="rayon">Rayon</option>
                                        <option value="silk">Silk</option>
                                        <option value="georgette">Georgette</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label class="form-label">Fit</label>
                                    <select name="fit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="regular">Regular</option>
                                        <option value="slim">Slim</option>
                                        <option value="a-line">A-line</option>
                                        <option value="flared">Flared</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label class="form-label">Top Length</label>
                                    <select name="top_length" class="form-control">
                                        <option value="">Select</option>
                                        <option value="short">Short</option>
                                        <option value="knee-length">Knee Length</option>
                                        <option value="long">Long</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-3">
                                    <label class="form-label">Pattern</label>
                                    <select name="pattern" class="form-control">
                                        <option value="">Select</option>
                                        <option value="solid">Solid</option>
                                        <option value="printed">Printed</option>
                                        <option value="embroidered">Embroidered</option>
                                    </select>
                                </div>

                                <!-- Image Uploads -->
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Gallery Images</label>
                                    <input type="file" name="gallery_images[]" class="form-control" multiple
                                        accept="image/*">
                                </div>

                                <!-- SEO -->
                                <div class="col-md-6 mt-3">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group input-group-outline my-2">
                                        <label class="form-label">Meta Description</label>
                                        <textarea name="meta_description" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>

                                <!-- Variants Section -->
                                <div class="card mb-4">
                                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                        <h6>Variants (Color + Size)</h6>
                                        <button type="button" class="btn btn-sm btn-dark" onclick="addVariant()">Add
                                            Variant</button>
                                    </div>
                                    <div class="card-body px-4 pt-2 pb-4">
                                        <div id="variant-container">
                                            <!-- Variant rows will be appended here -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
                                </div>

                </form>
            </div>

            <script>
                function focused(el) {
                    el.parentElement.classList.add('is-focused');
                }

                function defocused(el) {
                    if (!el.value) {
                        el.parentElement.classList.remove('is-focused');
                    }
                }

                function addVariant() {
                    const container = document.getElementById('variant-container');
                    const index = container.children.length;
                    const html = `
        <div class="row border rounded p-2 mb-3 position-relative variant-item">
          <div class="col-md-3">
            <label class="form-label">Color</label>
            <select name="variants[\${index}][color_id]" class="form-control" required>
              @foreach($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Size</label>
            <select name="variants[\${index}][size_id]" class="form-control" required>
              @foreach($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Price</label>
            <input type="number" name="variants[\${index}][price]" class="form-control" required>
          </div>
          <div class="col-md-2">
            <label class="form-label">Sale Price</label>
            <input type="number" name="variants[\${index}][sale_price]" class="form-control">
          </div>
          <div class="col-md-2">
            <label class="form-label">Stock</label>
            <input type="number" name="variants[\${index}][stock]" class="form-control" required>
          </div>
          <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="this.closest('.variant-item').remove()">
            &times;
          </button>
        </div>
      `;
                    container.insertAdjacentHTML('beforeend', html);
                }
            </script>

@endsection