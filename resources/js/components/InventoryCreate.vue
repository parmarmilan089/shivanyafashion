<template>
  <div>
    <div v-if="!sizes || sizes.length === 0" class="alert alert-warning">
      Loading sizes... Please wait.
    </div>
    <div v-else>
      <form @submit.prevent="handleSubmit">
        <!-- Basic Product Info -->
        <div class="card px-sm-4 px-3 py-3">
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Product Name</label>
                <input type="text" v-model="form.name" class="form-control" required />
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">SKU</label>
                <input type="text" v-model="form.sku" class="form-control" required />
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <div class="w-100 position-relative">
                  <select v-model="form.fabric" class="form-control">
                    <option value="">Select fabric</option>
                    <option value="cotton">Cotton</option>
                    <option value="rayon">Rayon</option>
                    <option value="silk">Silk</option>
                    <option value="georgette">Georgette</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="form.fit" class="form-control">
                  <option value="">Select Fit</option>
                  <option value="regular">Regular</option>
                  <option value="slim">Slim</option>
                  <option value="a-line">A-line</option>
                  <option value="flared">Flared</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="form.top_length" class="form-control">
                  <option value="">Select Top Length</option>
                  <option value="short">Short</option>
                  <option value="long">Long</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="form.pattern" class="form-control">
                  <option value="">Select Pattern</option>
                  <option value="solid">Solid</option>
                  <option value="printed">Printed</option>
                  <option value="embroidered">Embroidered</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Short Description</label>
                <textarea v-model="form.short_description" class="form-control" rows="3"
                  placeholder="Enter short description..."></textarea>
              </div>
            </div>
            <div class="col-md-12 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Full Description</label>
                <textarea v-model="form.full_description" class="form-control" rows="6"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Categories -->
        <div class="card px-sm-4 px-3 py-3 my-3">
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="selectedCategoryId" class="form-control">
                  <option value="">Select Category</option>
                  <option v-for="cat in categories.filter(c => c.category_type === 0)" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="selectedSubcategoryId" class="form-control" :disabled="!selectedCategoryId">
                  <option value="">Select Subcategory</option>
                  <option v-for="sub in filteredSubcategories" :key="sub.id" :value="sub.id">
                    {{ sub.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="input-group input-group-outline my-2">
                <select v-model="selectedSubsubcategoryId" class="form-control" :disabled="!selectedSubcategoryId">
                  <option value="">Select Sub-subcategory</option>
                  <option v-for="subsub in filteredSubsubcategories" :key="subsub.id" :value="subsub.id">
                    {{ subsub.name }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!-- Main Image & Gallery -->

        <div class="card px-sm-4 px-3 py-3 my-3">
          <div class="row">
            <div class="col-md-6 my-2">
              <div class="file-div">
                <h6 class="file-title">Main Image</h6>
                <input type="file" class="form-control file-input w-100" accept="image/*" @change="handleMainImage"
                  required />
              </div>
            </div>
            <div class="col-md-6 my-2">
              <div class="file-div">
                <h6 class="file-title">Gallery Images</h6>
                <input type="file" class="form-control file-input w-100" accept="image/*" multiple
                  @change="handleGalleryImages" />
              </div>
            </div>
          </div>
        </div>

        <!-- SEO Fields -->
        <div class="card px-sm-4 px-3 py-3">
          <div class="row">
            <div class="col-md-6 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Meta Title</label>
                <input type="text" v-model="form.meta_title" class="form-control" />
              </div>
            </div>
            <div class="col-md-6 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Meta Keywords</label>
                <input type="text" v-model="form.meta_keywords" class="form-control" />
              </div>
            </div>
            <div class="col-md-12 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Meta Description</label>
                <textarea v-model="form.meta_description" class="form-control" rows="5"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Status & Featured -->
        <div class="card px-sm-4 px-3 py-3 my-3">
          <div class="row">
            <div class="col-md-4 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Status</label>
                <select v-model="form.status" class="form-control">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="draft">Draft</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Featured Product</label>
                <select v-model="form.featured" class="form-control">
                  <option value="inactive">Inactive</option>
                  <option value="active">Active</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 my-2">
              <div class="input-group input-group-outline my-2">
                <label class="form-label">Stock Status</label>
                <select v-model="form.stock_status" class="form-control">
                  <option value="in_stock">In Stock</option>
                  <option value="out_of_stock">Out of Stock</option>
                  <option value="low_stock">Low Stock</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Variants -->
        <div class="card px-3 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h6>Variants</h6>
            <button type="button" class="btn btn-sm btn-dark" @click="addVariant">Add Variant</button>
          </div>
          <div v-for="(variant, vIndex) in form.variants" :key="vIndex" class="variant-block border p-3 mb-4 bg-white">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
              <div class="col-md-4">
                <div class="input-group input-group-outline my-2">
                  <label class="form-label">Select Color</label>
                  <select v-model="variant.color_id" class="form-control">
                    <option v-for="color in colors" :value="color.id" :key="color.id">{{ color.name }}</option>
                  </select>
                </div>
              </div>
              <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-sm btn-success" @click="addSizeRow(vIndex)">Add Size</button>
                <button type="button" class="btn btn-sm btn-danger" @click="removeVariant(vIndex)">Remove Variant</button>
              </div>
            </div>
            <div class="mt-3">
              <div class="row fw-bold text-dark mb-2">
                <div class="col-md-2">Size</div>
                <div class="col-md-2">Price</div>
                <div class="col-md-2">Sale Price</div>
                <div class="col-md-2">Stock</div>
                <div class="col-md-2">Sale Start</div>
                <div class="col-md-2">Sale End</div>
              </div>
              <!-- Loop over all variants -->

              <!-- Sizes inside this variant -->
              <div v-for="(size, sizeIndex) in variant.sizes" :key="sizeIndex" class="row mb-2">
                <div class="col-md-2">
                  <div class="input-group input-group-outline my-2">
                    <select v-model="size.size_id" class="form-control">
                      <option value="">Select Size</option>
                      <option v-for="sz in sizes" :value="sz.id" :disabled="isSizeUsedInVariant(sz.id, vIndex)">
                        {{ sz.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <!-- Other inputs: price, sale price etc. -->
                <div class="col-md-2">
                  <div class="input-group input-group-outline my-2">
                    <input v-model="size.price" class="form-control" placeholder="Price" @input="autoFillPrice(vIndex, sizeIndex, $event.target.value)" />
                    <div v-if="size.priceError" class="error-message">{{ size.priceError }}</div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="input-group input-group-outline my-2">
                    <input v-model="size.sale_price" class="form-control" :class="{ 'is-invalid': size.salePriceError }" placeholder="Sale Price" @input="autoFillSalePrice(vIndex, sizeIndex, $event.target.value)" />
                    <div v-if="size.salePriceError" class="error-message">{{ size.salePriceError }}</div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="input-group input-group-outline my-2">
                    <input v-model="size.stock" class="form-control" placeholder="Stock" @input="autoFillStock(vIndex, sizeIndex, $event.target.value)" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="input-group input-group-outline my-2">
                    <input v-model="size.sale_start" type="date" class="form-control" @change="autoFillSaleStart(vIndex, sizeIndex, $event.target.value)" />
                  </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                  <div class="input-group input-group-outline my-2">
                    <input v-model="size.sale_end" type="date" class="form-control" @change="autoFillSaleEnd(vIndex, sizeIndex, $event.target.value)" />
                  </div>
                  <button @click="removeSizeRow(vIndex, sizeIndex)" class="btn btn-sm btn-outline-danger">X</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button @click="addlog()" type="button" class="btn bg-gradient-dark text-white">Add Log</button>

        <div class="text-end mt-4">
          <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
  props: {
    categories: {
      type: Array,
      default: () => []
    },
    subcategories: {
      type: Array,
      default: () => []
    },
    subsubcategories: {
      type: Array,
      default: () => []
    },
    colors: {
      type: Array,
      default: () => []
    },
    sizes: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {
        name: '',
        sku: '',
        fabric: '',
        fit: '',
        top_length: '',
        pattern: '',
        short_description: '',
        full_description: '',
        main_image: null,
        gallery_images: [],
        meta_title: '',
        meta_keywords: '',
        meta_description: '',
        status: 'active',
        featured: 'inactive',
        variants: [
          {
            color_id: '',
            sizes: []
          }
        ]
      },
      selectedCategoryId: '',
      selectedSubcategoryId: '',
      selectedSubsubcategoryId: ''
    };
  },
  computed: {
    filteredSubcategories() {
      return Array.isArray(this.subcategories) ? this.subcategories.filter(cat => cat.category_type === 1 && cat.parent_id === Number(this.selectedCategoryId)) : [];
    },
    filteredSubsubcategories() {
      return Array.isArray(this.subsubcategories)
        ? this.subsubcategories.filter(
          cat => cat.category_type === 2 && cat.parent_id === Number(this.selectedSubcategoryId)
        )
        : [];
    }
  },
  watch: {
    sizes: {
      handler(newSizes) {
        console.log('Sizes prop changed:', newSizes);
        if (Array.isArray(newSizes) && newSizes.length > 0) {
          console.log('Sizes are now available');
        }
      },
      immediate: true
    },
    colors: {
      handler(newColors) {
        console.log('Colors prop changed:', newColors);
        if (Array.isArray(newColors) && newColors.length > 0) {
          console.log('Colors are now available');
        }
      },
      immediate: true
    }
  },
  mounted() {
    console.log('Sizes:', this.sizes);

    // Validate that all required props are available
    if (!Array.isArray(this.sizes) || this.sizes.length === 0) {
      console.warn('Sizes prop is empty or not an array');
    }
    if (!Array.isArray(this.colors) || this.colors.length === 0) {
      console.warn('Colors prop is empty or not an array');
    }
    if (!Array.isArray(this.categories) || this.categories.length === 0) {
      console.warn('Categories prop is empty or not an array');
    }
  },
  methods: {
    addlog() {
      console.log(this.form, 'variants');
    },

    // Calculate default price and stock from variants
    calculateDefaultValues() {
      let totalStock = 0;
      let lowestPrice = null;

      this.form.variants.forEach(variant => {
        if (variant.sizes && variant.sizes.length > 0) {
          variant.sizes.forEach(size => {
            // Calculate total stock
            if (size.stock && !isNaN(size.stock)) {
              totalStock += parseInt(size.stock);
            }

            // Find lowest price
            if (size.price && !isNaN(size.price)) {
              const price = parseFloat(size.price);
              if (lowestPrice === null || price < lowestPrice) {
                lowestPrice = price;
              }
            }
          });
        }
      });

      // Update form with calculated values
      this.form.price = lowestPrice ? lowestPrice.toString() : '';
      this.form.stock_qty = totalStock.toString();
    },
    isSizeUsed(sizeId, variantIndex) {
      if (!this.form.variants[variantIndex] || !this.form.variants[variantIndex].sizes) {
        return false;
      }
      const usedIds = this.form.variants[variantIndex].sizes.map((s) => s.size_id);
      return usedIds.includes(sizeId);
    },
    isSizeUsedInVariant(sizeId, variantIndex) {
      if (!this.form.variants[variantIndex] || !this.form.variants[variantIndex].sizes) {
        return false;
      }
      return this.form.variants[variantIndex].sizes.some(size => size.size_id === sizeId);
    },
    fetchColors() {
      // Colors are passed as props, no need to fetch
      console.log('Colors available:', this.colors);
    },
    fetchSizes() {
      // Sizes are passed as props, no need to fetch
      console.log('Sizes available:', this.sizes);
    },
    handleMainImage(e) {
      this.form.main_image = e.target.files[0];
    },
    handleGalleryImages(e) {
      this.form.gallery_images = [...e.target.files];
    },
    addVariant() {
      // Clone the first variant's size data if it exists
      let newVariant = { color_id: '', sizes: [] };

      if (this.form.variants.length > 0 && this.form.variants[0].sizes.length > 0) {
        // Clone each size from the first variant
        newVariant.sizes = this.form.variants[0].sizes.map(size => ({
          size_id: size.size_id,
          price: size.price,
          sale_price: size.sale_price,
          stock: size.stock,
          sale_start: size.sale_start,
          sale_end: size.sale_end,
          priceError: '',
          salePriceError: ''
        }));
      }

      this.form.variants.push(newVariant);
      console.log(this.form.variants, 'this.form.variants');
    },
    addSizeRow(variantIndex) {
      const variant = this.form.variants[variantIndex];
      if (!variant.sizes) {
        variant.sizes = [];
      }

      const selectedSizeIds = variant.sizes.map((size) => size.size_id);

      // Check if sizes prop exists and is an array
      if (!Array.isArray(this.sizes) || this.sizes.length === 0) {
        console.error('Sizes prop is not available or empty');
        Swal.fire({
          icon: 'error',
          title: 'Sizes Not Available',
          text: 'Sizes are not available. Please refresh the page.'
        });
        return;
      }

      // Find first unused size
      const availableSize = this.sizes.find(sz => !selectedSizeIds.includes(sz.id));
      if (!availableSize) {
        Swal.fire({
          title: 'No More Sizes Available',
          text: 'All sizes have been added for this variant.',
          icon: 'info',
          confirmButtonText: 'OK'
        });
        return;
      }

      variant.sizes.push({
        size_id: availableSize.id,
        price: '',
        sale_price: '',
        stock: '',
        sale_start: '',
        sale_end: '',
        priceError: '',
        salePriceError: ''
      });
    },
    removeSizeRow(variantIndex, sizeIndex) {
      if (this.form.variants[variantIndex] && this.form.variants[variantIndex].sizes) {
        this.form.variants[variantIndex].sizes.splice(sizeIndex, 1);
      }
    },
    removeVariant(variantIndex) {
      if (this.form.variants.length > 1) {
        Swal.fire({
          title: 'Remove Variant?',
          text: 'Are you sure you want to remove this variant?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, remove it!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            this.form.variants.splice(variantIndex, 1);
            Swal.fire(
              'Removed!',
              'Variant has been removed.',
              'success'
            );
          }
        });
      } else {
        Swal.fire({
          title: 'Cannot Remove',
          text: 'You must have at least one variant.',
          icon: 'warning',
          confirmButtonText: 'OK'
        });
      }
    },
    // Auto-fill methods for variant data
    autoFillPrice(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        // Update all sizes in this variant with the same price
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) { // Don't update the current size
            size.price = value;
          }
        });

        // Validate sale prices after price change
        this.validateSalePrices(variantIndex);
      }
    },

    autoFillSalePrice(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        // Update all sizes in this variant with the same sale price
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) { // Don't update the current size
            size.sale_price = value;
          }
        });

        // Validate sale prices
        this.validateSalePrices(variantIndex);
      }
    },

    autoFillStock(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        // Update all sizes in this variant with the same stock
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) { // Don't update the current size
            size.stock = value;
          }
        });
      }
    },

    autoFillSaleStart(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        // Update all sizes in this variant with the same sale start date
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) { // Don't update the current size
            size.sale_start = value;
          }
        });
      }
    },

    autoFillSaleEnd(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        // Update all sizes in this variant with the same sale end date
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) { // Don't update the current size
            size.sale_end = value;
          }
        });
      }
    },

    // Validation methods
    validateSalePrices(variantIndex) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach(size => {
          // Clear previous errors
          size.salePriceError = '';

          if (size.price && size.sale_price) {
            const price = parseFloat(size.price);
            const salePrice = parseFloat(size.sale_price);

            if (salePrice >= price) {
              size.salePriceError = 'Sale price must be less than regular price';
            }
          }
        });
      }
    },

    handleSubmit() {
      // Clear previous validation errors
      this.clearValidationErrors();

      let hasErrors = false;
      const errors = [];

      // 1. Basic product information validation
      if (!this.form.name || this.form.name.trim() === '') {
        errors.push('Product name is required');
        hasErrors = true;
      }

      if (!this.form.sku || this.form.sku.trim() === '') {
        errors.push('SKU is required');
        hasErrors = true;
      }

      // 2. Category validation
      if (!this.selectedCategoryId) {
        errors.push('Please select a category');
        hasErrors = true;
      }

      // 3. Main image validation
      if (!this.form.main_image) {
        errors.push('Main image is required');
        hasErrors = true;
      }

      // 4. Variants validation
      if (!this.form.variants || this.form.variants.length === 0) {
        errors.push('At least one variant is required');
        hasErrors = true;
      }

      // 5. Validate each variant
      this.form.variants.forEach((variant, variantIndex) => {
        // Color validation
        if (!variant.color_id) {
          errors.push(`Variant ${variantIndex + 1}: Color is required`);
          hasErrors = true;
        }

        // Sizes validation
        if (!variant.sizes || variant.sizes.length === 0) {
          errors.push(`Variant ${variantIndex + 1}: At least one size is required`);
          hasErrors = true;
        }

        // Validate each size in the variant
        variant.sizes.forEach((size, sizeIndex) => {
          if (!size.size_id) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Size selection is required`);
            hasErrors = true;
          }

          if (!size.price || size.price <= 0) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Valid price is required`);
            hasErrors = true;
          }

          if (!size.sale_price || size.sale_price <= 0) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Valid sale price is required`);
            hasErrors = true;
          }

          if (!size.stock || size.stock < 0) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Valid stock quantity is required`);
            hasErrors = true;
          }

          // Sale price validation
          if (size.price && size.sale_price) {
            const price = parseFloat(size.price);
            const salePrice = parseFloat(size.sale_price);

            if (salePrice >= price) {
              errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Sale price must be less than regular price`);
              hasErrors = true;
            }
          }
        });
      });

      // 6. Check for duplicate sizes within each variant
      this.form.variants.forEach((variant, variantIndex) => {
        const sizeIds = variant.sizes.map(size => size.size_id).filter(id => id);
        const uniqueSizeIds = [...new Set(sizeIds)];

        if (sizeIds.length !== uniqueSizeIds.length) {
          errors.push(`Variant ${variantIndex + 1}: Duplicate sizes are not allowed`);
          hasErrors = true;
        }
      });

      // 7. Check for duplicate colors across variants
      const colorIds = this.form.variants.map(variant => variant.color_id).filter(id => id);
      const uniqueColorIds = [...new Set(colorIds)];

      if (colorIds.length !== uniqueColorIds.length) {
        errors.push('Duplicate colors are not allowed across variants');
        hasErrors = true;
      }

      // If there are errors, show them and stop submission
      if (hasErrors) {
        const errorList = errors.map(error => `• ${error}`).join('<br>');

        Swal.fire({
          title: 'Validation Errors',
          html: `<div style="text-align: left; max-height: 400px; overflow-y: auto;">
            <p>Please fix the following errors:</p>
            <div style="margin-top: 10px;">${errorList}</div>
          </div>`,
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#d33',
          width: '600px'
        });
        return;
      }

      // All validations passed - show confirmation dialog
      Swal.fire({
        title: 'Confirm Submission',
        text: 'Are you sure you want to save this product?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          console.log('Form submitted successfully:', this.form);
          this.submitForm();
        }
      });
    },

    clearValidationErrors() {
      // Clear any previous validation errors
      this.form.variants.forEach(variant => {
        if (variant.sizes) {
          variant.sizes.forEach(size => {
            size.salePriceError = '';
          });
        }
      });
    },

    submitForm() {
      // Calculate default values from variants
      this.calculateDefaultValues();

      // Create FormData for file uploads
      const formData = new FormData();

      // Add basic form data
      formData.append('name', this.form.name);
      formData.append('sku', this.form.sku);
      formData.append('fabric', this.form.fabric);
      formData.append('fit', this.form.fit);
      formData.append('top_length', this.form.top_length);
      formData.append('pattern', this.form.pattern);
      formData.append('short_description', this.form.short_description);
      formData.append('full_description', this.form.full_description);
      formData.append('category_id', this.selectedCategoryId);
      formData.append('subcategory_id', this.selectedSubcategoryId);
      formData.append('subsubcategory_id', this.selectedSubsubcategoryId);
      formData.append('meta_title', this.form.meta_title);
      formData.append('meta_keywords', this.form.meta_keywords);
      formData.append('meta_description', this.form.meta_description);
      formData.append('status', this.form.status);
      formData.append('featured', this.form.featured);
      formData.append('price', this.form.price);
      formData.append('stock_qty', this.form.stock_qty);
      formData.append('stock_status', this.form.stock_status);

      // Add main image
      if (this.form.main_image) {
        formData.append('main_image', this.form.main_image);
      }

      // Add gallery images
      if (this.form.gallery_images && this.form.gallery_images.length > 0) {
        this.form.gallery_images.forEach(image => {
          formData.append('gallery_images[]', image);
        });
      }

      // Add variants data as JSON
      formData.append('variants', JSON.stringify(this.form.variants));

      // Show loading state
      Swal.fire({
        title: 'Saving Product...',
        text: 'Please wait while we save your product.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Submit the form using axios
      console.log('Submitting form data...');

      console.log(formData, 'formData');
      axios.post('/admin/inventory', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        console.log('Success:', response.data);
        Swal.fire({
          title: 'Success!',
          text: 'Product has been saved successfully.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          // Redirect to product list or reset form
          window.location.href = '/admin/inventory';
        });
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire({
          title: 'Error!',
          text: error.response?.data?.message || 'An error occurred while saving the product.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      });
    }
  }
};
</script>

<style scoped>
.variant-block {
  border-radius: 10px;
}

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
