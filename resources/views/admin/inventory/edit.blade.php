@extends('admin.layout.page')
@section('content')

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
                                <div class="input-group input-group-outline my-2">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $inventory->name }}" required>
                                </div>
                            </div>

                            <!-- SKU -->
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <label class="form-label">SKU</label>
                                    <input type="text" name="sku" class="form-control" value="{{ $inventory->sku }}" required>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <div class="my-2">
                                    <label class="form-label d-block">Category</label>
                                    <select name="category_id" id="category-select" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $inventory->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="col-md-6">
                                <div class="my-2">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" id="tag-input" placeholder="Type and press Enter" value="{{ $inventory->tags }}" />
                                </div>
                            </div>

                            <!-- General Price & Stock Info -->
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

                            <div class="col-md-3">
                                <div class="input-group input-group-outline my-2">
                                    <label class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock_qty" class="form-control" value="{{ $inventory->stock_qty }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group-outline my-2">
                                    <select name="stock_status" class="form-control" id="stock_status">
                                        <option value="in_stock" {{ $inventory->stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ $inventory->stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="pre_order" {{ $inventory->stock_status == 'pre_order' ? 'selected' : '' }}>Pre-order</option>
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
                                <input type="file" name="gallery_images[]" class="form-control" multiple accept="image/*">
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

                            <!-- Variant Matrix Section -->
                            <div class="col-md-12 mt-4">
                                <h6>Product Variants</h6>
                                <table class="table table-bordered" id="variant-table">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Sale Price</th>
                                            <th>Stock Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="variant[0][color_id]" class="form-control">
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="variant[0][size_id]" class="form-control">
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="variant[0][price]" class="form-control" required></td>
                                            <td><input type="number" name="variant[0][sale_price]" class="form-control"></td>
                                            <td><input type="number" name="variant[0][stock_qty]" class="form-control" required></td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-primary" id="add-variant">Add Variant</button>
                            </div>
                            <select class="form-control" name="choices-button" id="choices-button" placeholder="Departure">
  <option value="Choice 1" selected="">Brazil</option>
  <option value="Choice 2">Bucharest</option>
  <option value="Choice 3">London</option>
  <option value="Choice 4">USA</option>
</select>
                            <!-- Submit -->
                            <div class="col-md-6 mt-4">
                                <button type="submit" class="btn bg-gradient-dark text-white w-100">Save Product</button>
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
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
      if (document.getElementById('choices-button')) {
        var element = document.getElementById('choices-button');
        const example = new Choices(element, {});
      }
</script>
<script>
    const tagInput = document.getElementById('tag-input');
    new Choices(tagInput, {
        removeItemButton: true,
        delimiter: ',',
        placeholderValue: 'Enter tags...',
        duplicateItemsAllowed: false
    });

    new Choices('#category-select', {
        placeholderValue: 'Select Category',
        searchPlaceholderValue: 'Search category...',
        shouldSort: false
    });

    new Choices('#stock_status', {
        placeholderValue: 'Select Status',
        searchPlaceholderValue: 'Search Status...',
        shouldSort: false
    });

    // Dynamic variant logic
    let rowIndex = 1;
    document.getElementById('add-variant').addEventListener('click', function () {
        const tableBody = document.querySelector('#variant-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="variant[${rowIndex}][color_id]" class="form-control">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="variant[${rowIndex}][size_id]" class="form-control">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="variant[${rowIndex}][price]" class="form-control" required></td>
            <td><input type="number" name="variant[${rowIndex}][sale_price]" class="form-control"></td>
            <td><input type="number" name="variant[${rowIndex}][stock_qty]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
        rowIndex++;
    });

    document.querySelector('#variant-table tbody').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush
