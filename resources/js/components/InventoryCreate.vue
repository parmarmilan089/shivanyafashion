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
              <option value="knee-length">Knee Length</option>
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
          <select v-model="form.category_id" class="form-control">
            <option value="">Select Category</option>
            <option v-for="cat in categories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
          </select>
        </div>
        <div class="col-md-6 col-lg-3">
          <select v-model="form.subcategory_id" class="form-control">
            <option value="">Select Sub Category</option>
            <option v-for="cat in subcategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
          </select>
        </div>
        <div class="col-md-6 col-lg-3">
          <select v-model="form.subsubcategory_id" class="form-control">
            <option value="">Select Sub Sub Category</option>
            <option v-for="cat in subsubcategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
          </select>
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
          <label class="form-label">Meta Title</label>
          <input type="text" v-model="form.meta_title" class="form-control" />
        </div>
        <div class="col-md-6 my-2">
          <label class="form-label">Meta Keywords</label>
          <input type="text" v-model="form.meta_keywords" class="form-control" />
        </div>
        <div class="col-md-12 my-2">
          <label class="form-label">Meta Description</label>
          <textarea v-model="form.meta_description" class="form-control" rows="5"></textarea>
        </div>
      </div>
    </div>

    <!-- Status & Featured -->
    <div class="card px-sm-4 px-3 py-3 my-3">
      <div class="row">
        <div class="col-md-6 my-2">
          <label class="form-label">Status</label>
          <select v-model="form.status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="draft">Draft</option>
          </select>
        </div>
        <div class="col-md-6 my-2">
          <label class="form-label">Featured Product</label>
          <select v-model="form.featured" class="form-control">
            <option value="inactive">Inactive</option>
            <option value="active">Active</option>
          </select>
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
            <label class="form-label">Select Color</label>
            <select v-model="variant.color_id" class="form-control">
              <option v-for="color in colors" :value="color.id" :key="color.id">{{ color.name }}</option>
            </select>
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
              <select v-model="size.size_id" class="form-control">
                <option v-for="sizeOpt in sizes" :value="sizeOpt.id" :key="sizeOpt.id">{{ sizeOpt.name }}</option>
              </select>
            </div>
            <div class="col-md-2">
              <input v-model.number="size.price" type="number" class="form-control" />
            </div>
            <div class="col-md-2">
              <input v-model.number="size.sale_price" type="number" class="form-control" />
            </div>
            <div class="col-md-2">
              <input v-model.number="size.stock" type="number" class="form-control" />
            </div>
            <div class="col-md-2">
              <input v-model="size.sale_start" type="date" class="form-control" />
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
      colors: [],
      sizes: []
    };
  },
  mounted() {
    this.fetchColors();
    this.fetchSizes();
  },
  methods: {
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
      this.form.variants[variantIndex].sizes.push({
        size_id: '',
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
      console.log(this.form);
    }
  }
};
</script>

<style scoped>
.variant-block {
  border-radius: 10px;
}
</style>