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
                                <!-- <label class="form-label">Select Category</label> -->
                                <div class="w-100 position-relative">
                                    <select name="category_id" id="category-select" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="position-absolute end-4 top-10 mt-1 milan">
                                        >

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tags -->
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Type and press Enter</label>
                                <input type="text" name="tags" id="tag-input" class="form-control" placeholder="" />
                            </div>
                        </div>
                        <!-- General Price & Stock Info -->
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" step="0.01" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Sale Price</label>
                                <input type="number" name="sale_price" step="0.01" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock_qty" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="stock_status" class="form-control" id="stock_status">
                                        <option value="in_stock">In Stock</option>
                                        <option value="out_of_stock">Out of Stock</option>
                                        <option value="pre_order">Pre-order</option>
                                    </select>
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Colors -->
                        <div class="col-md-6 col-lg-3">
                            <div class="input-group input-group-outline my-2">
                                <div class="w-100 position-relative">
                                    <select name="Colors" class="form-control" id="Colors">
                                        <option value="in_stock">Colors</option>
                                        <option value="out_of_stock">White</option>
                                        <option value="pre_order">Black</option>
                                    </select>
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
                                </div>
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
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
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
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
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
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
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
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
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
                                    <div class="position-absolute end-4 top-10 mt-1">
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <input type="file" name="main_image" class="form-control file-input w-100"
                                        accept="image/*" required>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 my-2">
                            <div class="file-div">
                                <div class="w-100">
                                    <h6 class="file-title">
                                        Gallery Images
                                    </h6>
                                    <input type="file" name="gallery_images[]" class="form-control file-input w-100"
                                        multiple accept="image/*">
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
                    <div
                        class="w-100 p-2 d-flex justify-content-between align-items-center gap-3 flex-wrap variants-main-div">
                        <h6 class="m-0 ">Variants (Color + Size)</h6>
                        <button type="button" class="btn btn-sm btn-dark m-0 " onclick="addVariant()">Add
                            Variant</button>
                    </div>
                    <div class="px-3">
                        <div id="variant-container">
                            <!-- Variant rows will be appended here -->
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
                </div>
            </form>



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
                <div class="row border rounded p-2 mt-3 position-relative variant-item">
                <div class="col-md-3">
                <label class="form-label">Color</label>
                <div class="input-group input-group-outline ">
                 <select name="variants[\${index}][color_id]" class="form-control" required>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
                </select>
                </div>

                </div>
                <div class="col-md-3">
                <label class="form-label">Size</label>
                <div class="input-group input-group-outline ">
                <select name="variants[\${index}][size_id]" class="form-control" required>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
                </select>
                </div>
                
                </div>
                <div class="col-md-2">
                <label class="form-label">Price</label>
                 <div class="input-group input-group-outline ">
                 <input type="number" name="variants[\${index}][price]" class="form-control" required>
                </div>
                </div>
                <div class="col-md-2">
                <label class="form-label">Sale Price</label>
                 <div class="input-group input-group-outline ">
                 <input type="number" name="variants[\${index}][sale_price]" class="form-control">
                </div>
                </div>
                <div class="col-md-2">
                <label class="form-label">Stock</label>
                 <div class="input-group input-group-outline ">
                 <input type="number" name="variants[\${index}][stock]" class="form-control" required>
                </div>
                </div>
                 <div class="col-md-12">
                <div class='d-flex w-100 justify-content-end'>
                <button type="button" class="btn btn-sm btn-danger mt-2 mb-0" onclick="this.closest('.variant-item').remove()">
                &times;
                </button></div>
                </div>
                </div>
                `;
                    container.insertAdjacentHTML('beforeend', html);
                }
            </script>

@endsection