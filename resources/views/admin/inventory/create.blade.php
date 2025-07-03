@extends('admin.layout.page')
@section('contect')

    <style>
        .is-invalid {
            border: 1px solid red !important;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 2px;
        }

        .add-size-btn i {
            color: white !important;
            font-size: 20px !important;
        }

        .add-size-btn i:hover,
        .add-size-btn:hover {
            color: white !important;
        }

        .remove-size-row {
            width: 32px;
            height: 32px;
            padding: 0;
            line-height: 1;
            font-size: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .ck-editor__editable_inline {
            min-height: 200px;
            border-radius: 8px;
            padding: 10px;
            border-color: #ced4da;
        }

        /* file input */
        .size-rows-title {
            background-color: #f1f1f1;
            padding: 6px 0;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 12px;
        }

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
                @csrf
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
                    <div class="row">
                        <!-- Short Description -->
                        <div class="col-md-12 my-2">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3"
                                    placeholder="Enter short description..."></textarea>
                            </div>
                        </div>

                        <!-- Full Description with WYSIWYG -->
                        <!-- Full Description with CKEditor -->
                        <div class="col-md-12 my-2">
                            <label class="form-label">Full Description</label>
                            <textarea name="full_description" id="editor" class="form-control" rows="6"></textarea>
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
                                            @if($cat->category_type == 0)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <!-- <label class="form-label">Select Category</label> -->
                                <div class="w-100 position-relative">
                                    <select name="category_id" id="subcategory-select" class="form-control" required>
                                        <option value="">Select Sub Category</option>
                                        @foreach($categories as $cat)
                                            @if($cat->category_type == 0)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <!-- <label class="form-label">Select Category</label> -->
                                <div class="w-100 position-relative">
                                    <select name="category_id" id="subsubcategory-select" class="form-control" required>
                                        <option value="">Select Sub Sub Category</option>
                                        @foreach($categories as $cat)
                                            @if($cat->category_type == 0)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-lg-3">
                                                                                            <div class="input-group input-group-outline my-2">
                                                                                                <label class="form-label">Type and press Enter</label>
                                                                                                <input type="text" name="tags" id="tag-input" class="form-control" placeholder="" />
                                                                                            </div>
                                                                                        </div> -->
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
    <div class="card px-sm-4 px-3 py-3 my-3">
        <div class="row">
            <div class="col-md-6 my-2">
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
            </div>
            <div class="col-md-6 my-2">
                <div class="w-100 text-base mt-4 d-flex align-items-center gap-1 mb-2">
                    <h5 class="m-0">Featured Product :</h5>
                    <div class="">
                        <select name="status" class="form-control py-0 px-2">
                            <option value="inactive">Inactive</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card px-3 py-3">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <h6>Variants</h6>
            <!-- <h6>Variants (Color + Size)</h6> -->
            <button type="button" class="btn btn-sm btn-dark" id="add-color-variant">Add Variant</button>
        </div>
        <div id="variant-container" class="mt-3">
            <!-- First Variant Block -->
            <div class="variant-block border p-3 mb-4 bg-white" data-color-index="0">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-2">
                            <select class="form-control" name="variants[0][color_id]" required>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-sm btn-success add-size-btn" data-color-index="0"><i
                                class="material-symbols-rounded opacity-5">add_box</i> <span>Add Size</span></button>
                    </div>
                </div>
                <div class="mt-3 size-rows" id="variant-sizes-0">
                    <div class="row fw-bold text-dark mb-2">
                        <div class="col-md-2">Size</div>
                        <div class="col-md-2">Price</div>
                        <div class="col-md-2">Sale Price</div>
                        <div class="col-md-2">Stock</div>
                        <div class="col-md-2">Sale Start</div>
                        <div class="col-md-2">Sale End</div>
                    </div>
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
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        $('#category-select, #subcategory-select, #subsubcategory-select').select2({
            placeholder: "Select an option",
            width: '100%'
        });
        $(document).ready(function () {
            $('#category-select').on('change', function () {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('admin.get-subcategories') }}",
                        type: "GET",
                        data: {
                            category_id: categoryId
                        },
                        success: function (data) {
                            $('#subcategory-select').empty().append('<option value="">Select Sub Category</option>');
                            $.each(data, function (key, subcat) {
                                $('#subcategory-select').append('<option value="' + subcat.id + '">' + subcat.name + '</option>');
                            });
                        },
                        error: function () {
                            console.error('Failed to fetch subcategories.');
                        }
                    });
                } else {
                    $('#subcategory-select').empty().append('<option value="">Select Sub Category</option>');
                }
            });

            $('#subcategory-select').on('change', function () {
                const subcategoryId = $(this).val();

                $('#subsubcategory-select').empty().append('<option value="">Loading...</option>');

                if (subcategoryId) {
                    $.ajax({
                        url: '{{ route('admin.get-subsubcategories') }}',
                        type: 'GET',
                        data: { subcategory_id: subcategoryId },
                        success: function (response) {
                            $('#subsubcategory-select').empty().append('<option value="">Select Sub Sub Category</option>');
                            response.forEach(function (item) {
                                $('#subsubcategory-select').append(`<option value="${item.id}">${item.name}</option>`);
                            });
                        },
                        error: function () {
                            alert('Failed to load sub-subcategories');
                            $('#subsubcategory-select').empty().append('<option value="">Select Sub Sub Category</option>');
                        }
                    });
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const editorElement = document.querySelector('#editor');
            if (editorElement) {
                ClassicEditor
                    .create(editorElement)
                    .catch(error => {
                        console.error('CKEditor init error:', error);
                    });
            }
        });
    </script>
    <script>
        let colorIndex = 1;

        // Add new color variant
        $('#add-color-variant').on('click', function () {
            let cloneFrom = $('.variant-block').first();
            let variantHtml = '';

            if (cloneFrom.length > 0) {
                let sizeRows = '';
                cloneFrom.find('.size-row').each(function (i) {
                    const sizeVal = $(this).find('select').val();
                    const sizeText = $(this).find('select option:selected').text();
                    const price = $(this).find('.price-input').val();
                    const salePrice = $(this).find('.sale-price-input').val();
                    const stock = $(this).find('.stock-input').val();
                    const start = $(this).find('.sale-start-input').val();
                    const end = $(this).find('.sale-end-input').val();

                    sizeRows += `
                    <div class="row size-row mb-2" data-size-index="${i}">
                        <div class="col-md-2">
                            <div class="input-group input-group-outline my-2">
                                <select class="form-control" name="variants[${colorIndex}][sizes][${i}][size_id]" required>
                                    <option value="${sizeVal}" selected>${sizeText}</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-outline my-2">
                                <input type="number" name="variants[${colorIndex}][sizes][${i}][price]" value="${price}" class="form-control price-input" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-outline my-2">
                                <input type="number" name="variants[${colorIndex}][sizes][${i}][sale_price]" value="${salePrice}" class="form-control sale-price-input" placeholder="Sale Price">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-outline my-2">
                                <input type="number" name="variants[${colorIndex}][sizes][${i}][stock]" value="${stock}" class="form-control stock-input" placeholder="Stock">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-outline my-2">
                                <input type="date" name="variants[${colorIndex}][sizes][${i}][sale_start]" value="${start}" class="form-control sale-start-input">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <div class="input-group input-group-outline my-2 w-100">
                                <input type="date" name="variants[${colorIndex}][sizes][${i}][sale_end]" value="${end}" class="form-control sale-end-input">
                            </div>
                            <i class="remove-size-row material-symbols-rounded opacity-5 mt-2">delete</i>
                        </div>
                    </div>
                `;
                });

                variantHtml = `
                <div class="variant-block border p-3 mb-4 bg-white" data-color-index="${colorIndex}">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="col-md-4">
                            <label class="form-label">Select Color</label>
                            <div class="input-group input-group-outline my-2">
                                <select class="form-control" name="variants[${colorIndex}][color_id]" required>
                                    <option value="">-- Select --</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-sm btn-success add-size-btn" data-color-index="${colorIndex}"><i class="material-symbols-rounded opacity-5">add_box</i> <span>Add Size</span></button>
                            <button type="button" class="btn btn-sm btn-danger remove-variant-block">Remove Variant</button>
                        </div>
                    </div>
                    <div class="mt-3 size-rows" id="variant-sizes-${colorIndex}">
                        ${sizeRows}
                    </div>
                </div>`;
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
            let sizeIndex = $(`#variant-sizes-${index} .size-row`).length;

            const selectedSizes = $(`#variant-sizes-${index} select`).map(function () {
                return $(this).val();
            }).get();

            let options = `@foreach($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
            @endforeach`;

            for (const size of selectedSizes) {
                options = options.replace(`value="${size}"`, `value="${size}" disabled`);
            }

            let sizeRow = `
                <div class="row size-row mb-2" data-size-index="${sizeIndex}">
                    <div class="col-md-2">
                        <div class="input-group input-group-outline my-2">
                            <select class="form-control" name="variants[${index}][sizes][${sizeIndex}][size_id]" required>
                                ${options}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-outline my-2">
                            <input type="number" name="variants[${index}][sizes][${sizeIndex}][price]" class="form-control price-input" placeholder="Price">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-outline my-2">
                            <input type="number" name="variants[${index}][sizes][${sizeIndex}][sale_price]" class="form-control sale-price-input" placeholder="Sale Price">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-outline my-2">
                            <input type="number" name="variants[${index}][sizes][${sizeIndex}][stock]" class="form-control stock-input" placeholder="Stock">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-outline my-2">
                            <input type="date" name="variants[${index}][sizes][${sizeIndex}][sale_start]" class="form-control sale-start-input">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <div class="input-group input-group-outline my-2 w-100">
                            <input type="date" name="variants[${index}][sizes][${sizeIndex}][sale_end]" class="form-control sale-end-input">
                        </div>
                        <i class="remove-size-row material-symbols-rounded opacity-5 mt-2">delete</i>
                    </div>
                </div>
            `;

            $(`#variant-sizes-${index}`).append(sizeRow);
        });

        // Auto-fill price to all inputs in the same variant block
        $(document).on('input', '.variant-block .price-input', function () {
            const val = $(this).val();
            const block = $(this).closest('.variant-block');
            block.find('.price-input').val(val);
        });

        $(document).on('input', '.variant-block .sale-price-input', function () {
            const val = $(this).val();
            const block = $(this).closest('.variant-block');
            block.find('.sale-price-input').val(val);
        });

        $(document).on('input', '.variant-block .stock-input', function () {
            const val = $(this).val();
            const block = $(this).closest('.variant-block');
            block.find('.stock-input').val(val);
        });

        $(document).on('change', '.variant-block .sale-start-input', function () {
            const val = $(this).val();
            const block = $(this).closest('.variant-block');
            block.find('.sale-start-input').val(val);
        });

        $(document).on('change', '.variant-block .sale-end-input', function () {
            const val = $(this).val();
            const block = $(this).closest('.variant-block');
            block.find('.sale-end-input').val(val);
        });


    </script>
    <script>
        // Live sale price vs price check
        $(document).on('input', '.sale-price-input', function () {
            const saleInput = $(this);
            const wrapper = saleInput.closest('.col-md-2');
            const priceInput = saleInput.closest('.size-row').find('.price-input');
            const priceVal = parseFloat(priceInput.val());
            const saleVal = parseFloat(saleInput.val());

            wrapper.find('.error-message').remove();
            saleInput.removeClass('is-invalid');

            if (!isNaN(priceVal) && !isNaN(saleVal) && saleVal >= priceVal) {
                saleInput.addClass('is-invalid');
                wrapper.append('<div class="error-message">Sale price must be less than price</div>');
            }
        });

        // Main form submit validation
        $('form').on('submit', function (e) {
            let isValid = true;

            $('.variant-block').each(function () {
                const $block = $(this);
                const colorIndex = $block.data('color-index');

                // Color validation
                const colorSelect = $block.find(`select[name="variants[${colorIndex}][color_id]"]`);
                const colorWrapper = colorSelect.closest('.col-md-4');
                colorSelect.removeClass('is-invalid');
                colorWrapper.find('.error-message').remove();

                if (!colorSelect.val()) {
                    isValid = false;
                    colorSelect.addClass('is-invalid');
                    colorWrapper.append('<div class="error-message">Color is required</div>');
                }

                // Validate each size row
                $block.find('.size-row').each(function () {
                    const $row = $(this);

                    const size = $row.find('select');
                    const price = $row.find('.price-input');
                    const salePrice = $row.find('.sale-price-input');
                    const stock = $row.find('.stock-input');
                    const startDate = $row.find('.sale-start-input');
                    const endDate = $row.find('.sale-end-input');

                    // Clear old errors
                    $row.find('.form-control').removeClass('is-invalid');
                    $row.find('.error-message').remove();

                    // Validate each field and show message inside column
                    function validateField(input, message) {
                        const col = input.closest('.col-md-2');
                        if (!input.val()) {
                            input.addClass('is-invalid');
                            col.append(`<div class="error-message">${message}</div>`);
                            isValid = false;
                        }
                    }

                    validateField(size, 'Size is required');
                    validateField(price, 'Price is required');
                    validateField(salePrice, 'Sale price is required');
                    validateField(stock, 'Stock is required');

                    // Sale price must be less than price
                    const pVal = parseFloat(price.val());
                    const spVal = parseFloat(salePrice.val());
                    if (pVal && spVal && spVal >= pVal) {
                        const col = salePrice.closest('.col-md-2');
                        salePrice.addClass('is-invalid');
                        col.append('<div class="error-message">Sale price must be less than price</div>');
                        isValid = false;
                    }

                    // Validate dates
                    if (startDate.val() && endDate.val()) {
                        const start = new Date(startDate.val());
                        const end = new Date(endDate.val());
                        if (end <= start) {
                            const col = endDate.closest('.col-md-2');
                            endDate.addClass('is-invalid');
                            col.append('<div class="error-message">End date must be after start date</div>');
                            isValid = false;
                        }
                    }
                });
            });

            if (!isValid) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(".is-invalid:first").offset().top - 100
                }, 500);
            }
        });
    </script>
@endpush