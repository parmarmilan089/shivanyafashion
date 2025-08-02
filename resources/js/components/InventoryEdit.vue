<template>
  <div>
    <div v-if="!formLoaded" class="alert alert-warning">
      Loading inventory...
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
                    <option value="heavy-real-georgette">Heavy Real Georgette</option>
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
          <div v-if="form.variants.length === 0" class="text-center text-muted my-3">
            No variants yet. Click "Add Variant" to create one.
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
                <button type="button" class="btn btn-sm btn-dark" @click="addSizeRow(vIndex)">Add Size</button>
                <button type="button" class="btn btn-sm btn-danger" @click="removeVariant(vIndex)">
                  <i class="material-icons">delete</i>
                </button>
              </div>
            </div>

            <!-- Variant Images -->
            <div class="row mt-3">
              <div class="col-md-6 my-2">
                <div class="file-div">
                  <h6 class="file-title">Variant Main Image</h6>
                  <input type="file" class="form-control file-input w-100" accept="image/*" @change="handleVariantMainImage(vIndex, $event)" />
                  <div class="file-info mt-2">
                    <small class="text-muted">
                      <i class="material-icons" style="font-size: 14px;">info</i>
                      Max file size: 2MB | Supported: JPEG, PNG, GIF, WebP
                    </small>
                  </div>
                  <div v-if="variant.main_image">
                    <img
                      :src="variant.main_image_preview ? variant.main_image_preview : (typeof variant.main_image === 'string' ? '/storage/' + variant.main_image : '')"
                      alt="Current Variant Main Image"
                      style="max-width: 120px; margin-top: 10px;"
                    />
                  </div>
                </div>
              </div>
              <div class="col-md-6 my-2">
                <div class="file-div">
                  <h6 class="file-title">Variant Gallery Images</h6>
                  <input type="file" class="form-control file-input w-100" accept="image/*" multiple @change="handleVariantGalleryImages(vIndex, $event)" />
                  <div class="file-info mt-2">
                    <small class="text-muted">
                      <i class="material-icons" style="font-size: 14px;">info</i>
                      Max file size: 2MB | Supported: JPEG, PNG, GIF, WebP
                    </small>
                  </div>
                  <!-- Combined Gallery Images Display -->
                  <div v-if="getCombinedGalleryImages(vIndex).length > 0" class="gallery-container">
                    <div v-for="(img, index) in getCombinedGalleryImages(vIndex)" :key="img.id" style="display: inline-block; margin: 5px; position: relative;">
                      <img :src="img.url" :alt="img.alt" style="max-width: 80px; height: 80px; object-fit: cover; border-radius: 8px;" />
                      <button
                        type="button"
                        @click="removeGalleryImage(vIndex, index, img.type)"
                        class="btn btn-sm btn-danger gallery-remove-btn"
                        title="Remove image">
                        ×
                      </button>
                      <div v-if="img.type === 'new'" class="new-image-badge">New</div>
                    </div>
                  </div>
                  <div v-else class="text-muted text-center mt-3">
                    <small>No gallery images selected</small>
                  </div>
                </div>
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
                  <button type="button" @click="removeSizeRow(vIndex, sizeIndex)" class="btn btn-sm btn-outline-danger">X</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button type="submit" class="btn bg-gradient-dark text-white">Update Product</button>
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
    inventory: { type: Object, required: true },
    categories: { type: Array, default: () => [] },
    subcategories: { type: Array, default: () => [] },
    subsubcategories: { type: Array, default: () => [] },
    colors: { type: Array, default: () => [] },
    sizes: { type: Array, default: () => [] },
    variants: { type: Array, default: () => [] }
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
        price: '',
        stock_qty: '',
        stock_status: 'in_stock',
        variants: []
      },
      selectedCategoryId: '',
      selectedSubcategoryId: '',
      selectedSubsubcategoryId: '',
      formLoaded: false,
      currentGalleryImages: [],
      newGalleryImages: []
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
    },
    parsedGalleryImages() {
      if (this.currentGalleryImages.length > 0) {
        return this.currentGalleryImages;
      }
      if (!this.inventory.gallery_images) return [];
      try {
        return JSON.parse(this.inventory.gallery_images);
      } catch {
        return [];
      }
    }
  },
  mounted() {
    this.populateForm();
  },
  methods: {
    populateForm() {
      const inv = this.inventory;
      let variantsArr = [];
      if (Array.isArray(this.variants) && this.variants.length > 0) {
        variantsArr = this.variants;
      } else if (Array.isArray(inv.variants)) {
        variantsArr = inv.variants;
      } else if (typeof inv.variants === 'string' && inv.variants.trim() !== '') {
        try {
          variantsArr = JSON.parse(inv.variants);
        } catch {
          variantsArr = [];
        }
      }
      this.form = {
        name: inv.name || '',
        sku: inv.sku || '',
        fabric: inv.fabric || '',
        fit: inv.fit || '',
        top_length: inv.top_length || '',
        pattern: inv.pattern || '',
        short_description: inv.short_description || '',
        full_description: inv.full_description || '',

        meta_title: inv.meta_title || '',
        meta_keywords: inv.meta_keywords || '',
        meta_description: inv.meta_description || '',
        status: inv.status || 'active',
        featured: inv.featured || 'inactive',
        price: inv.price || '',
        stock_qty: inv.stock_qty || '',
        stock_status: inv.stock_status || 'in_stock',
        variants: Array.isArray(variantsArr) ? variantsArr.map(variant => ({
          ...variant,
          newGalleryImages: variant.newGalleryImages || []
        })) : []
      };
      this.selectedCategoryId = inv.category_id ? String(inv.category_id) : '';
      this.selectedSubcategoryId = inv.subcategory_id ? String(inv.subcategory_id) : '';
      this.selectedSubsubcategoryId = inv.subsubcategory_id ? String(inv.subsubcategory_id) : '';

      // Initialize current gallery images
      if (inv.gallery_images) {
        try {
          this.currentGalleryImages = JSON.parse(inv.gallery_images);
        } catch {
          this.currentGalleryImages = [];
        }
      } else {
        this.currentGalleryImages = [];
      }

      this.formLoaded = true;
    },

    handleVariantMainImage(variantIndex, event) {
      const file = event.target.files[0];

      if (!file) return;

      const validation = this.validateImageFile(file);
      if (!validation.valid) {
        Swal.fire({
          title: 'File Validation Error',
          text: validation.message,
          icon: 'error',
          confirmButtonText: 'OK'
        });
        // Clear the file input
        event.target.value = '';
        return;
      }

      // Assign file and preview URL
      this.form.variants[variantIndex].main_image = file;
      this.form.variants[variantIndex].main_image_preview = URL.createObjectURL(file);

      // Show success message
      Swal.fire({
        title: 'Image Added',
        text: 'Main image added successfully!',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
      });
    },
    handleVariantGalleryImages(variantIndex, event) {
      const files = Array.from(event.target.files);
      const invalidFiles = [];

      // Validate all files
      files.forEach(file => {
        const validation = this.validateImageFile(file);
        if (!validation.valid) {
          invalidFiles.push({
            name: file.name,
            message: validation.message
          });
        }
      });

      if (invalidFiles.length > 0) {
        const errorMessages = invalidFiles.map(file =>
          `<strong>${file.name}</strong>: ${file.message}`
        ).join('<br><br>');

        Swal.fire({
          title: 'File Validation Error',
          html: `The following files have issues:<br><br>${errorMessages}<br><br>Please select valid files.`,
          icon: 'error',
          confirmButtonText: 'OK'
        });
        // Clear the file input
        event.target.value = '';
        return;
      }

      // Initialize arrays if they don't exist
      if (!this.form.variants[variantIndex].gallery_images) {
        this.form.variants[variantIndex].gallery_images = [];
      }
      if (!this.form.variants[variantIndex].newGalleryImages) {
        this.form.variants[variantIndex].newGalleryImages = [];
      }

      // Preserve existing string images (from database) and add new File objects
      const existingImages = this.form.variants[variantIndex].gallery_images.filter(img => typeof img === 'string');
      this.form.variants[variantIndex].gallery_images = [
        ...existingImages,
        ...files
      ];

      // Create preview URLs for new images
      files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.form.variants[variantIndex].newGalleryImages.push({
            id: `new-${variantIndex}-${Date.now()}-${index}`,
            url: e.target.result,
            file: file,
            type: 'new'
          });
        };
        reader.readAsDataURL(file);
      });

      // Show success message
      if (files.length > 0) {
        Swal.fire({
          title: 'Images Added',
          text: `${files.length} image(s) added successfully!`,
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
      }
    },
    getCombinedGalleryImages(variantIndex) {
      const variant = this.form.variants[variantIndex];
      const combinedImages = [];

      // Add existing gallery images
      if (variant.gallery_images && Array.isArray(variant.gallery_images)) {
        variant.gallery_images.forEach((img, index) => {
          if (typeof img === 'string') {
            // Existing image from database
            combinedImages.push({
              id: `existing-${variantIndex}-${index}`,
              url: `/storage/${img}`,
              alt: `Variant Gallery Image ${index + 1}`,
              type: 'existing',
              originalIndex: index
            });
          }
        });
      }

      // Add new gallery images
      if (variant.newGalleryImages && Array.isArray(variant.newGalleryImages)) {
        variant.newGalleryImages.forEach((img, index) => {
          combinedImages.push({
            id: img.id,
            url: img.url,
            alt: `New Variant Gallery Image ${index + 1}`,
            type: 'new',
            originalIndex: index
          });
        });
      }

      return combinedImages;
    },
    removeGalleryImage(variantIndex, displayIndex, imageType) {
      Swal.fire({
        title: 'Remove Image?',
        text: 'Are you sure you want to remove this image?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          const variant = this.form.variants[variantIndex];

          if (imageType === 'existing') {
            // Remove from existing gallery images (string paths)
            if (variant.gallery_images && Array.isArray(variant.gallery_images)) {
              const existingImages = variant.gallery_images.filter(img => typeof img === 'string');
              const originalIndex = this.getCombinedGalleryImages(variantIndex)[displayIndex].originalIndex;
              existingImages.splice(originalIndex, 1);

              // Reconstruct gallery_images array with remaining existing images and new File objects
              const newFileImages = variant.gallery_images.filter(img => img instanceof File);
              variant.gallery_images = [...existingImages, ...newFileImages];
            }
          } else if (imageType === 'new') {
            // Remove from new gallery images
            if (variant.newGalleryImages && Array.isArray(variant.newGalleryImages)) {
              const originalIndex = this.getCombinedGalleryImages(variantIndex)[displayIndex].originalIndex;
              variant.newGalleryImages.splice(originalIndex, 1);

              // Also remove from gallery_images array (File objects)
              const existingImages = variant.gallery_images.filter(img => typeof img === 'string');
              const newFileImages = variant.gallery_images.filter(img => img instanceof File);
              newFileImages.splice(originalIndex, 1);
              variant.gallery_images = [...existingImages, ...newFileImages];
            }
          }
          Swal.fire('Removed!', 'Image has been removed from gallery.', 'success');
        }
      });
    },
    addVariant() {
      let newVariant = {
        color_id: '',
        main_image: null,
        gallery_images: [],
        newGalleryImages: [],
        sizes: []
      };
      if (this.form.variants.length > 0 && this.form.variants[0].sizes.length > 0) {
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
    },
    addSizeRow(variantIndex) {
      const variant = this.form.variants[variantIndex];
      if (!variant.sizes) {
        variant.sizes = [];
      }
      const selectedSizeIds = variant.sizes.map((size) => size.size_id);
      if (!Array.isArray(this.sizes) || this.sizes.length === 0) {
        Swal.fire({
          icon: 'error',
          title: 'Sizes Not Available',
          text: 'Sizes are not available. Please refresh the page.'
        });
        return;
      }
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
            Swal.fire('Removed!', 'Variant has been removed.', 'success');
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
    isSizeUsedInVariant(sizeId, variantIndex) {
      if (!this.form.variants[variantIndex] || !this.form.variants[variantIndex].sizes) {
        return false;
      }
      return this.form.variants[variantIndex].sizes.some(size => size.size_id === sizeId);
    },
    autoFillPrice(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) {
            size.price = value;
          }
        });
        this.validateSalePrices(variantIndex);
      }
    },
    autoFillSalePrice(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) {
            size.sale_price = value;
          }
        });
        this.validateSalePrices(variantIndex);
      }
    },
    autoFillStock(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) {
            size.stock = value;
          }
        });
      }
    },
    autoFillSaleStart(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) {
            size.sale_start = value;
          }
        });
      }
    },
    autoFillSaleEnd(variantIndex, sizeIndex, value) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach((size, index) => {
          if (index !== sizeIndex) {
            size.sale_end = value;
          }
        });
      }
    },
    validateSalePrices(variantIndex) {
      const variant = this.form.variants[variantIndex];
      if (variant && variant.sizes) {
        variant.sizes.forEach(size => {
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
    validateForm() {
      let hasErrors = false;
      const errors = [];

      // Basic validation
      if (!this.form.name || this.form.name.trim() === '') {
        errors.push('Product name is required');
        hasErrors = true;
      }

      if (!this.selectedCategoryId) {
        errors.push('Please select a category');
        hasErrors = true;
      }

      // Validate variants
      this.form.variants.forEach((variant, variantIndex) => {
        if (!variant.color_id) {
          errors.push(`Variant ${variantIndex + 1}: Color is required`);
          hasErrors = true;
        }

        // Check if variant has main image (either existing or new)
        if (!variant.main_image) {
          errors.push(`Variant ${variantIndex + 1}: Main image is required`);
          hasErrors = true;
        }

        if (!variant.sizes || variant.sizes.length === 0) {
          errors.push(`Variant ${variantIndex + 1}: At least one size is required`);
          hasErrors = true;
        }

        // Validate each size
        variant.sizes.forEach((size, sizeIndex) => {
          if (!size.size_id) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Size selection is required`);
            hasErrors = true;
          }

          if (!size.price || size.price <= 0) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Valid price is required`);
            hasErrors = true;
          }

          if (!size.stock || size.stock < 0) {
            errors.push(`Variant ${variantIndex + 1}, Size ${sizeIndex + 1}: Valid stock quantity is required`);
            hasErrors = true;
          }
        });
      });

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
        return false;
      }

      return true;
    },
    handleSubmit() {
      if (!this.validateForm()) {
        return;
      }
      this.calculateDefaultValues();
      const formData = new FormData();
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

      // Add variant images
      this.form.variants.forEach((variant, variantIndex) => {
        if (variant.main_image && variant.main_image instanceof File) {
          formData.append(`variant_main_images[${variantIndex}]`, variant.main_image);
        }
        if (variant.gallery_images && variant.gallery_images.length > 0) {
          variant.gallery_images.forEach((image, imageIndex) => {
            // Only append if it's a File object (new upload)
            if (image instanceof File) {
              formData.append(`variant_gallery_images[${variantIndex}][${imageIndex}]`, image);
            }
          });
        }
      });

      formData.append('variants', JSON.stringify(this.form.variants));
      Swal.fire({
        title: 'Updating...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
      });
      axios.post(`/admin/inventory/${this.inventory.id}?_method=PUT`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      })
      .then(res => {
        Swal.fire({ title: 'Success!', text: 'Product updated.', icon: 'success' }).then(() => {
          window.location.href = '/admin/inventory';
        });
      })
      .catch(err => {
        Swal.fire({ title: 'Error', text: err.response?.data?.message || 'Update failed.', icon: 'error' });
      });
    },
    calculateDefaultValues() {
      let totalStock = 0;
      let lowestPrice = null;
      this.form.variants.forEach(variant => {
        if (variant.sizes && variant.sizes.length > 0) {
          variant.sizes.forEach(size => {
            if (size.stock && !isNaN(size.stock)) {
              totalStock += parseInt(size.stock);
            }
            if (size.price && !isNaN(size.price)) {
              const price = parseFloat(size.price);
              if (lowestPrice === null || price < lowestPrice) {
                lowestPrice = price;
              }
            }
          });
        }
      });
      this.form.price = lowestPrice ? lowestPrice.toString() : '';
      this.form.stock_qty = totalStock.toString();
    },
    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    validateImageFile(file) {
      // Check file type
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
      if (!allowedTypes.includes(file.type)) {
        return {
          valid: false,
          message: `File type "${file.type}" is not supported. Please use JPEG, PNG, GIF, or WebP.`
        };
      }

      // Check file size (2MB limit)
      const maxSize = 2 * 1024 * 1024; // 2MB
      if (file.size > maxSize) {
        return {
          valid: false,
          message: `File "${file.name}" (${this.formatFileSize(file.size)}) exceeds the 2MB limit.`
        };
      }

      return { valid: true };
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
.gallery-remove-btn {
  position: absolute;
  top: -8px;
  right: -8px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  font-size: 14px;
  line-height: 1;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
}
.gallery-container {
  margin-top: 15px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}
.new-image-badge {
  position: absolute;
  top: -8px;
  left: -8px;
  background: #28a745;
  color: white;
  font-size: 10px;
  padding: 2px 6px;
  border-radius: 10px;
  font-weight: bold;
  z-index: 10;
}
</style>
