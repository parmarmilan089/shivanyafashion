<template>
    <div>
      <div v-if="isLoadingSizes" class="alert alert-warning">
        Loading sizes... Please wait.
      </div>
      <div v-else>
        <form @submit.prevent="handleSubmit">
          <!-- Basic Product Info -->
          <div class="card px-sm-4 px-3 py-3">
            <div class="row">
              <div class="col-md-6 col-lg-3">
                <label>Product Name *</label>
                <input type="text" class="form-control" v-model="form.name" />
              </div>
              <div class="col-md-6 col-lg-3">
                <label>SKU *</label>
                <input type="text" class="form-control" v-model="form.sku" />
              </div>
              <div class="col-md-6 col-lg-3">
                <label>Fabric *</label>
                <input type="text" class="form-control" v-model="form.fabric" />
              </div>
              <div class="col-md-6 col-lg-3">
                <label>Fit *</label>
                <input type="text" class="form-control" v-model="form.fit" />
              </div>
              <div class="col-md-6 col-lg-3">
                <label>Top Length *</label>
                <input type="text" class="form-control" v-model="form.top_length" />
              </div>
              <div class="col-md-6 col-lg-3">
                <label>Pattern *</label>
                <input type="text" class="form-control" v-model="form.pattern" />
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="card px-sm-4 px-3 py-3 mt-3">
            <label>Short Description *</label>
            <textarea class="form-control mb-3" v-model="form.short_description"></textarea>
            <label>Full Description *</label>
            <textarea class="form-control mb-3" v-model="form.full_description"></textarea>
          </div>

          <!-- Meta -->
          <div class="card px-sm-4 px-3 py-3 mt-3">
            <div class="row">
              <div class="col-md-6 col-lg-4">
                <label>Meta Title</label>
                <input type="text" class="form-control" v-model="form.meta_title" />
              </div>
              <div class="col-md-6 col-lg-4">
                <label>Meta Keywords</label>
                <input type="text" class="form-control" v-model="form.meta_keywords" />
              </div>
              <div class="col-md-6 col-lg-4">
                <label>Meta Description</label>
                <input type="text" class="form-control" v-model="form.meta_description" />
              </div>
            </div>
          </div>

          <!-- Status & Featured -->
          <div class="card px-sm-4 px-3 py-3 mt-3">
            <div class="row">
              <div class="col-md-6 col-lg-3">
                <label>Status</label>
                <select class="form-control" v-model="form.status">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="col-md-6 col-lg-3">
                <label>Featured</label>
                <select class="form-control" v-model="form.featured">
                  <option value="active">Yes</option>
                  <option value="inactive">No</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Variants -->
          <div v-for="(variant, variantIndex) in form.variants" :key="variantIndex" class="card px-sm-4 px-3 py-3 mt-3">
            <h6>Variant {{ variantIndex + 1 }}</h6>
            <div class="row">
              <div class="col-md-6 col-lg-3">
                <label>Color *</label>
                <select class="form-control" v-model="variant.color_id">
                  <option value="">Select Color</option>
                  <option v-for="color in colors" :key="color.id" :value="color.id">
                    {{ color.name }}
                  </option>
                </select>
              </div>

              <div class="col-md-6 col-lg-3">
                <label>Main Image *</label>
                <input type="file" class="form-control" @change="e => variant.main_image = e.target.files[0]" />
              </div>

              <div class="col-md-6 col-lg-3">
                <label>Gallery Images</label>
                <input type="file" multiple class="form-control" @change="e => variant.gallery_images = Array.from(e.target.files)" />
              </div>
            </div>

            <!-- Sizes -->
            <div class="mt-3">
              <h6>Sizes</h6>
              <div v-for="(size, sizeIndex) in variant.sizes" :key="sizeIndex" class="row mb-2 align-items-end">
                <div class="col-md-2">
                  <label>Size</label>
                  <input type="text" class="form-control" v-model="size.size" />
                </div>
                <div class="col-md-2">
                  <label>Price</label>
                  <input type="number" class="form-control" v-model="size.price" @input="updateAllSizes(variantIndex, 'price', size.price, sizeIndex)" />
                </div>
                <div class="col-md-2">
                  <label>Qty</label>
                  <input type="number" class="form-control" v-model="size.qty" @input="updateAllSizes(variantIndex, 'qty', size.qty, sizeIndex)" />
                </div>
              </div>
            </div>
          </div>

          <!-- Add Variant -->
          <div class="text-end mt-3">
            <button type="button" class="btn btn-sm btn-primary" @click="addVariant">+ Add Variant</button>
          </div>

          <!-- Submit -->
          <div class="mt-4">
            <button type="submit" class="btn bg-gradient-dark text-white" :disabled="isSubmitting">
              <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-1"></span>
              {{ isSubmitting ? 'Saving...' : 'Save Product' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: ['colors', 'sizes'],
    data() {
      return {
        isLoadingSizes: true,
        isSubmitting: false,
        form: {
          name: '',
          sku: '',
          fabric: '',
          fit: '',
          top_length: '',
          pattern: '',
          short_description: '',
          full_description: '',
          meta_title: '',
          meta_keywords: '',
          meta_description: '',
          status: 'active',
          featured: 'inactive',
          variants: [{
            color_id: '',
            main_image: null,
            gallery_images: [],
            sizes: [],
          }],
        }
      };
    },
    watch: {
      sizes: {
        handler(newSizes) {
          this.isLoadingSizes = !(Array.isArray(newSizes) && newSizes.length > 0);
          if (this.form.variants.length && newSizes.length) {
            this.form.variants.forEach(variant => {
              variant.sizes = this.sizes.map(size => ({
                size: size.name,
                price: '',
                qty: '',
              }));
            });
          }
        },
        immediate: true
      }
    },
    methods: {
      addVariant() {
        this.form.variants.push({
          color_id: '',
          main_image: null,
          gallery_images: [],
          sizes: this.sizes.map(size => ({
            size: size.name,
            price: '',
            qty: '',
          })),
        });
      },
      updateAllSizes(variantIndex, field, value, skipIndex = null) {
        const sizes = this.form.variants[variantIndex].sizes;
        sizes.forEach((size, index) => {
          if (index !== skipIndex) size[field] = value;
        });
      },
      validateForm() {
        const errors = [];

        if (!this.form.name) errors.push("Product name is required");
        if (!this.form.sku) errors.push("SKU is required");
        if (!this.form.fabric) errors.push("Fabric is required");

        this.form.variants.forEach((variant, variantIndex) => {
          if (!variant.color_id) errors.push(`Variant ${variantIndex + 1}: Color is required`);
          if (!variant.main_image) errors.push(`Variant ${variantIndex + 1}: Main image is required`);

          variant.sizes.forEach((size, sizeIndex) => {
            if (!size.price || !size.qty) {
              errors.push(`Variant ${variantIndex + 1} - Size ${size.size}: Price and Qty required`);
            }
          });
        });

        return errors;
      },
      resetForm() {
        this.form = {
          name: '',
          sku: '',
          fabric: '',
          fit: '',
          top_length: '',
          pattern: '',
          short_description: '',
          full_description: '',
          meta_title: '',
          meta_keywords: '',
          meta_description: '',
          status: 'active',
          featured: 'inactive',
          variants: [{
            color_id: '',
            main_image: null,
            gallery_images: [],
            sizes: this.sizes.map(size => ({
              size: size.name,
              price: '',
              qty: '',
            }))
          }]
        };
      },
      handleSubmit() {
        const errors = this.validateForm();
        if (errors.length) {
          alert(errors.join('\n'));
          return;
        }

        this.isSubmitting = true;

        const formData = new FormData();
        Object.keys(this.form).forEach(key => {
          if (key !== 'variants') {
            formData.append(key, this.form[key]);
          }
        });

        formData.append('variants', JSON.stringify(this.form.variants));

        axios.post('/admin/products', formData)
          .then(() => {
            alert('Product saved successfully!');
            this.resetForm();
          })
          .catch(error => {
            console.error(error);
            alert('Something went wrong.');
          })
          .finally(() => {
            this.isSubmitting = false;
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
