@extends('admin.layout.page')
@section('contect')

    <style>
        /* file input */
        .file-div {
            background-color: #ff00000a;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed #e73b37;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px;
        }

        .file-div .file-title {
            font-size: 16px;
            line-height: normal;
            font-weight: 500;
            color: #e73b37;
            text-align: center;
            width: 100%;
            pointer-events: none;
            margin: 0;
        }

        .file-div .file-input {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9;
            opacity: 0;
            height: 100%;
        }

        .variants-main-div {
            background-color: #efefef;
            border-radius: 12px;
        }
    </style>

    <div class="w-100 ps-2 pe-4 ">
        <div class="w-100">
            <div class="w-100 text-base">
                <h4 class="mb-4">Add New Product</h6>
            </div>
            <form action="{{ route('admin.inventory.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card px-sm-4 px-3 py-3">
                    <div class="row">
                        <!-- Product Name -->
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>

                        <!-- SKU -->
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control" required>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="stock_Sizes" class="form-control" id="stock_Sizes">
                                        <option value="in_stock">Sizes</option>
                                        <option value="out_of_stock">Xs</option>
                                        <option value="pre_order">S</option>
                                        <option value="pre_order">M</option>
                                        <option value="pre_order">LG</option>
                                        <option value="pre_order">Xl</option>
                                        <option value="pre_order">FREE SIZE</option>
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="fabric" class="form-control" id="fabric">
                                        <option value="">Select fabric</option>
                                        <option value="cotton">Cotton</option>
                                        <option value="rayon">Rayon</option>
                                        <option value="silk">Silk</option>
                                        <option value="georgette">Georgette</option>
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="Fit" class="form-control" id="Fit">
                                        <option value="">Select Fit</option>
                                        <option value="regular">Regular</option>
                                        <option value="slim">Slim</option>
                                        <option value="a-line">A-line</option>
                                        <option value="flared">Flared</option>
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="top_length" class="form-control">
                                        <option value="">Select Top Length</option>
                                        <option value="short">Short</option>
                                        <option value="knee-length">Knee Length</option>
                                        <option value="long">Long</option>
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="Pattern" class="form-control">
                                        <option value="">Select Pattern</option>
                                        <option value="solid">Solid</option>
                                        <option value="printed">Printed</option>
                                        <option value="embroidered">Embroidered</option>
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card px-sm-4 px-3 py-3 my-3">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <!-- <label class="form-label">Select Category</label> -->
                                <div class="w-100 position-relative">
                                    <select name="category_id" id="category-select" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="position-absolute end-4 top-10 mt-1">
                                                                >
                                                            </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Type and press Enter</label>
                                <input type="text" name="tags" id="tag-input" class="form-control" placeholder="" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tags -->

                <!-- Gallery -->

        </div>
    </div>
    <div class="card px-sm-4 px-3 py-3 my-3">
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="file-div">
                    <div class="w-100">
                        <h6 class="file-title">
                            Main Image
                        </h6>
                        <input type="file" name="main_image" class="form-control file-input w-100" accept="image/*"
                            required>
                    </div>
                </div>

            </div>
            <div class="col-md-6 my-2">
                <div class="file-div">
                    <div class="w-100">
                        <h6 class="file-title">
                            Gallery Images
                        </h6>
                        <input type="file" name="gallery_images[]" class="form-control file-input w-100" multiple
                            accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card px-sm-4 px-3 py-3">
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="input-group input-group-outline">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control">
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="input-group input-group-outline ">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control">
                </div>
            </div>
            <div class="col-md-12 my-2">
                <div class="input-group input-group-outline ">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="5"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 text-base mt-4 d-flex align-items-center gap-1 mb-2">
        <h5 class="m-0">Status :</h5>
        <div class="">
            <select name="status" class="form-control py-0 px-2">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="draft">Draft</option>
            </select>
        </div>
    </div>
    <div class="card px-3 py-3">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <h6>Variants (Color + Size)</h6>
            <button type="button" class="btn btn-sm btn-dark" id="add-color-variant">Add Variant</button>
        </div>
        <div id="variant-container" class="mt-3">
            <!-- First Variant Block -->
            <div class="variant-block border p-3 mb-4 bg-white" data-color-index="0">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="col-md-4">
                        <label class="form-label">Select Color</label>
                        <select class="form-control" name="variants[0][color_id]" required>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-sm btn-primary add-size-btn" data-color-index="0">Add Size
                            Row</button>
                    </div>
                </div>
                <div class="mt-3 size-rows" id="variant-sizes-0">
                    <!-- Size rows will be added here -->
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
    </div>
    </form>


@endsection
@push('scripts')
<script>
let colorIndex = 1;

// Add new color variant
$('#add-color-variant').on('click', function () {
    let cloneFrom = $('.variant-block').first();
    let variantHtml = '';

    if (cloneFrom.length > 0) {
        let sizeRows = cloneFrom.find('.size-row').map(function () {
            return `
                <div class="row size-row mb-2">
                    <div class="col-md-2">
                        <select class="form-control" name="variants[${colorIndex}][sizes][][size_id]" required>
                            ${$(this).find('select').val() ? `<option selected>${$(this).find('select').val()}</option>` : ''}
                        </select>
                    </div>
                    <div class="col-md-2"><input type="number" name="variants[${colorIndex}][sizes][][price]" class="form-control price-input" value="${$(this).find('.price-input').val()}" placeholder="Price"></div>
                    <div class="col-md-2"><input type="number" name="variants[${colorIndex}][sizes][][sale_price]" class="form-control sale-price-input" value="${$(this).find('.sale-price-input').val()}" placeholder="Sale Price"></div>
                    <div class="col-md-2"><input type="number" name="variants[${colorIndex}][sizes][][stock]" class="form-control stock-input" value="${$(this).find('.stock-input').val()}" placeholder="Stock"></div>
                    <div class="col-md-2"><input type="date" name="variants[${colorIndex}][sizes][][sale_start]" class="form-control sale-start-input" value="${$(this).find('.sale-start-input').val()}"></div>
                    <div class="col-md-2 d-flex gap-2">
                        <input type="date" name="variants[${colorIndex}][sizes][][sale_end]" class="form-control sale-end-input" value="${$(this).find('.sale-end-input').val()}">
                        <button type="button" class="btn btn-sm btn-danger remove-size-row">&times;</button>
                    </div>
                </div>`;
        }).get().join('');

        variantHtml = `
            <div class="variant-block border p-3 mb-4 bg-white" data-color-index="${colorIndex}">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="col-md-4">
                        <label class="form-label">Select Color</label>
                        <select class="form-control" name="variants[${colorIndex}][color_id]" required>
                            <option value="">-- Select --</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-sm btn-danger remove-variant-block">Remove Variant</button>
                    </div>
                </div>
                <div class="mt-3 size-rows" id="variant-sizes-${colorIndex}">
                    ${sizeRows}
                </div>
            </div>
        `;
    } else {
        alert('Please add the first variant with size details before cloning.');
        return;
    }

    $('#variant-container').append(variantHtml);
    colorIndex++;
});

// Remove variant block
$(document).on('click', '.remove-variant-block', function () {
    $(this).closest('.variant-block').remove();
});

// Remove size row
$(document).on('click', '.remove-size-row', function () {
    $(this).closest('.size-row').remove();
});

// Add size row manually to specific variant
$(document).on('click', '.add-size-btn', function () {
    let index = $(this).data('color-index');
    let sizeRow = `
        <div class="row size-row mb-2">  
            <div class="col-md-2">
                <select class="form-control" name="variants[${index}][sizes][][size_id]" required>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><input type="number" name="variants[${index}][sizes][][price]" class="form-control price-input" placeholder="Price"></div>
            <div class="col-md-2"><input type="number" name="variants[${index}][sizes][][sale_price]" class="form-control sale-price-input" placeholder="Sale Price"></div>
            <div class="col-md-2"><input type="number" name="variants[${index}][sizes][][stock]" class="form-control stock-input" placeholder="Stock"></div>
            <div class="col-md-2"><input type="date" name="variants[${index}][sizes][][sale_start]" class="form-control sale-start-input"></div>
            <div class="col-md-2 d-flex gap-2">
                <input type="date" name="variants[${index}][sizes][][sale_end]" class="form-control sale-end-input">
                <button type="button" class="btn btn-sm btn-danger remove-size-row">&times;</button>
            </div>
        </div>
    `;
    $(`#variant-sizes-${index}`).append(sizeRow);
});
</script>
@endpush