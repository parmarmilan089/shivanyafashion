<template>
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
        <div class="col-md-6 my-2">
          <div class="input-group input-group-outline my-2">
            <label class="form-label">Status</label>
            <select v-model="form.status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="draft">Draft</option>
            </select>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="input-group input-group-outline my-2">
            <label class="form-label">Featured Product</label>
            <select v-model="form.featured" class="form-control">
              <option value="inactive">Inactive</option>
              <option value="active">Active</option>
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
          <div v-for="(size, sIndex) in variant.sizes" :key="sIndex" class="row mb-2">
            <div class="col-md-2">
              <div class="input-group input-group-outline my-2">
                <select v-model="size.size_id" class="form-control">
                  <option value="">Select Size</option>
                  <option v-for="sz in sizes" :key="sz.id" :value="sz.id" :disabled="isSizeUsed(sz.id, variantIndex)">
                    {{ sz.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group input-group-outline my-2">
                <input v-model.number="size.price" type="number" class="form-control" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group input-group-outline my-2">
                <input v-model.number="size.sale_price" type="number" class="form-control" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group input-group-outline my-2">
                <input v-model.number="size.stock" type="number" class="form-control" />
              </div>
            </div>
            <div class="col-md-2">
              <div class="input-group input-group-outline my-2">
                <input v-model="size.sale_start" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-md-2 d-flex gap-2">
              <input v-model="size.sale_end" type="date" class="form-control" />
              <button type="button" class="btn btn-sm btn-outline-danger"
                @click="removeSizeRow(vIndex, sIndex)">X</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn bg-gradient-dark text-white">Save Product</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    categories: Array,
    subcategories: Array,
    subsubcategories: Array,
    colors: Array,
    sizes: Array
  },
  data() {
    return {

      form: {
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
      return Array.isArray(this.categories) ? this.subcategories.filter(cat => cat.category_type === 1 && cat.parent_id === Number(this.selectedCategoryId)) : [];
    },
    filteredSubsubcategories() {
      return Array.isArray(this.categories)
        ? this.subsubcategories.filter(
          cat => cat.category_type === 2 && cat.parent_id === Number(this.selectedSubcategoryId)
        )
        : [];
    },
    mounted() {
      console.log(this.colors, 'colors'); // ✅ should work now

      this.fetchColors();
      this.fetchSizes();
    },
  },
  methods: {
    isSizeUsed(sizeId, variantIndex) {
      const variant = this.form.variants?.[variantIndex];
      if (!variant || !Array.isArray(variant.sizes)) return false;

      return variant.sizes.some(s => s.size_id === sizeId);
    },
    fetchColors() {
      // Fetch from API or props
    },
    fetchSizes() {
      // Fetch from API or props
    },
    handleMainImage(e) {
      this.form.main_image = e.target.files[0];
    },
    handleGalleryImages(e) {
      this.form.gallery_images = [...e.target.files];
    },
    addVariant() {
      this.form.variants.push({ color_id: '', sizes: [] });
    },
    removeVariant(index) {
      this.form.variants.splice(index, 1);
    },
    addSizeRow(variantIndex) {
      const variant = this.form.variants[variantIndex];
      const selectedSizeIds = variant.sizes.map(size => size.size_id);

      // Find first unused size from global sizes list
      const availableSize = this.sizes.find(size => !selectedSizeIds.includes(size.id));

      if (!availableSize) {
        alert("All sizes already added to this variant.");
        return;
      }

      variant.sizes.push({
        size_id: availableSize.id,
        price: '',
        sale_price: '',
        stock: '',
        sale_start: '',
        sale_end: ''
      });
    },
    removeSizeRow(variantIndex, sizeIndex) {
      this.form.variants[variantIndex].sizes.splice(sizeIndex, 1);
    },
    handleSubmit() {
      // Basic validation and form submission logic
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