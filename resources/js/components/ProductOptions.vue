<template>
  <div>
    <div class="row">
				<!-- Product Images Section -->
				<div class="col-md-6 mb-md-0 mb-4">
                    <div class="product-image-slider">
                        <!-- Main Image Display -->
                        <div class="main-image-container">
                            <img
                                id="mainImage"
                                :src="currentMainImage"
                                class="main-product-image"
                                :alt="product.name"
                            >

                            <!-- Navigation Arrows -->
                            <button
                                v-if="allImages.length > 1"
                                @click="previousImage"
                                class="slider-nav-btn slider-nav-prev"
                                :disabled="currentImageIndex === 0"
                            >
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button
                                v-if="allImages.length > 1"
                                @click="nextImage"
                                class="slider-nav-btn slider-nav-next"
                                :disabled="currentImageIndex === allImages.length - 1"
                            >
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <!-- Image Counter -->
                            <div v-if="allImages.length > 1" class="image-counter">
                                {{ currentImageIndex + 1 }} / {{ allImages.length }}
                            </div>
                        </div>

                        <!-- Thumbnail Navigation -->
                        <div v-if="allImages.length > 1" class="thumbnail-container">
                            <div
                                v-for="(img, idx) in allImages"
                                :key="idx"
                                class="thumbnail-item"
                                :class="{ 'active': idx === currentImageIndex }"
                                @click="setCurrentImage(idx)"
                            >
                                <img
                                    :src="img"
                                    class="thumbnail-image"
                                    :alt="`${product.name} - Image ${idx + 1}`"
                                >
                            </div>
                        </div>
                    </div>
				</div>

				<!-- Product Details Section -->
				<div class="col-md-6 position-sticky top-0">
					<!-- <p class="product-price mb-2">Category: {{ product.category.name ?? 'N/A' }}</p> -->
					<p class="product-price mb-2">Category: {{ product.category?.name ?? 'N/A' }}</p>
					<h2 class="product-details-title mb-3">{{ product.name }}</h2>

					<!-- Short Description -->
					<div v-if="product.short_description" class="product-short-description mb-3">
						<p class="text-muted">{{ product.short_description }}</p>
					</div>

					<!-- Product Highlights -->
					<div v-if="product.highlights" class="product-highlights mb-3">
						<h6 class="fw-bold mb-2">Highlights:</h6>
						<ul class="highlights-list">
							<li v-for="(highlight, index) in highlightsList" :key="index">
								{{ highlight }}
							</li>
						</ul>
					</div>

					<!-- Product Specifications -->
					<div class="product-specifications mb-3">
						<h6 class="fw-bold mb-2">Specifications:</h6>
						<div class="specs-grid">
							<div v-if="product.fabric" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('fabric') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.fabric) }}</span>
							</div>
							<div v-if="product.fit" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('fit') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.fit) }}</span>
							</div>
							<div v-if="product.pattern" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('pattern') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.pattern) }}</span>
							</div>
							<div v-if="product.neck_style" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('neck_style') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.neck_style) }}</span>
							</div>
							<div v-if="product.sleeve_type" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('sleeve_type') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.sleeve_type) }}</span>
							</div>
							<div v-if="product.top_length" class="spec-item">
								<span class="spec-label">{{ capitalizeFirst('top_length') }}:</span>
								<span class="spec-value">{{ capitalizeFirst(product.top_length) }}</span>
							</div>
						</div>
					</div>
					<div class="mb-3">
                        <label class="form-label d-block">Color:</label>
                        <div class="color-options d-flex gap-2 flex-wrap">
                            <button
                                v-for="color in colorOptions"
                                :key="color.color_id"
                                type="button"
                                class="color-option"
                                :class="{ 'active': selectedColor === color.color_id }"
                                @click="selectColor(color.color_id)"
                                :title="color.color_name"
                            >
                                <span class="color-dot" :style="{ backgroundColor: color.color_code || '#ccc' }"></span>
                                <span class="color-name">{{ color.color_name }}</span>
                            </button>
                        </div>
                    </div>

                        <div class="mb-3">
                        <label class="form-label d-block">Size:</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <label v-for="size in sizeOptions" :key="size.size_id" class="size-radio-container">
                            <input
                                type="radio"
                                class="size-radio-input"
                                :value="size.size_id"
                                v-model="selectedSize"
                                @change="onSizeChange"
                            >
                            <span class="size-radio-box">{{ size.size_name }}</span>
                            </label>
                        </div>
                        </div>

                        <div class="mb-4">
                            <div class="product-price-display">
                                <span class="current-price product-title d-block">
                                    ₹{{ currentPrice ? currentPrice.toLocaleString() : 'N/A' }}
                                </span>
                                <span v-if="isSaleActive && selectedVariant && selectedVariant.sale_price" class="original-price text-muted text-decoration-line-through ms-2">
                                    ₹{{ originalPrice.toLocaleString() }}
                                </span>
                            </div>
                        </div>

                        <!-- Full Description Toggle -->
                        <div v-if="product.full_description" class="product-full-description mb-3">
                            <button
                                @click="showFullDescription = !showFullDescription"
                                class="btn btn-link p-0 text-decoration-none"
                                type="button"
                            >
                                <span v-if="!showFullDescription">Show Full Description</span>
                                <span v-else>Hide Full Description</span>
                                <i :class="showFullDescription ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="ms-2"></i>
                            </button>

                            <div v-if="showFullDescription" class="full-description-content mt-2">
                                <div v-html="product.full_description"></div>
                            </div>
                        </div>

                        <!-- Care Instructions -->
                        <div v-if="product.care_instructions" class="care-instructions mb-3">
                            <h6 class="fw-bold mb-2">Care Instructions:</h6>
                            <p class="text-muted small">{{ product.care_instructions }}</p>
                        </div>

                        <div class="mb-sm-4 mb-3 d-flex align-items-center gap-3 flex-sm-row flex-column">
                        <div class="input-group-qut d-flex align-items-center gap-2 justify-content-between">
                            <button @click="updateQty(-1)" class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt">-</button>
                            <input type="number" v-model.number="quantity" class="p-0 border-0 bg-transparent text-center" min="1">
                            <button @click="updateQty(1)" class="d-flex align-items-center justify-content-center border-0 p-0 bg-transparent btn-qt">+</button>
                        </div>
                        <button class="w-100 flex-1 border-btn product-title" @click="addToCart">ADD TO CART <span class="atc-dot"></span>  ₹{{ totalPrice }}</button>
                        </div>
				</div>
			</div>

  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'ProductOptions',
  props: {
    variants: {
      type: Array,
      required: true
    },
    product: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedColor: null,
      selectedSize: null,
      quantity: 1,
      selectedImage: null,
      currentImageIndex: 0,
      showFullDescription: false,
    };
  },
  computed: {
    colorOptions() {
      return this.variants.map(colorGroup => ({
        color_id: colorGroup.color_id,
        color_name: colorGroup.color_name,
        color_code: colorGroup.color_code,
        main_image: colorGroup.main_image,
        gallery_images: colorGroup.gallery_images
      }));
    },
    selectedColorGroup() {
      return this.variants.find(colorGroup => colorGroup.color_id === this.selectedColor);
    },
    sizeOptions() {
      return this.selectedColorGroup ? this.selectedColorGroup.variants : [];
    },
    selectedVariant() {
      if (!this.selectedColorGroup) return null;
      return this.selectedColorGroup.variants.find(v => v.size_id === this.selectedSize);
    },
    isSaleActive() {
      if (!this.product.sale_start_date || !this.product.sale_end_date) {
        return false;
      }

      const now = new Date();
      const startDate = new Date(this.product.sale_start_date);
      const endDate = new Date(this.product.sale_end_date);

      return now >= startDate && now <= endDate;
    },
    currentPrice() {
      if (!this.selectedVariant) return 0;

      if (this.isSaleActive && this.selectedVariant.sale_price) {
        return this.selectedVariant.sale_price;
      }

      return this.selectedVariant.price;
    },
    originalPrice() {
      if (!this.selectedVariant) return 0;
      return this.selectedVariant.price;
    },
    totalPrice() {
      return this.currentPrice * this.quantity;
    },
    galleryImages() {
      if (this.selectedColorGroup && this.selectedColorGroup.gallery_images) {
        try {
          const imgs = typeof this.selectedColorGroup.gallery_images === 'string'
            ? JSON.parse(this.selectedColorGroup.gallery_images)
            : this.selectedColorGroup.gallery_images;
          if (Array.isArray(imgs) && imgs.length) return imgs;
        } catch (e) {
          console.error('Error parsing gallery images:', e);
        }
      }
      return [];
    },
    allImages() {
      const images = [];

      // Add main image first
      if (this.selectedColorGroup && this.selectedColorGroup.main_image) {
        images.push(this.selectedColorGroup.main_image);
      } else if (this.product.main_image) {
        images.push('/storage/' + this.product.main_image);
      }

      // Add gallery images
      if (this.galleryImages && this.galleryImages.length) {
        this.galleryImages.forEach(img => {
          let imagePath;
          if (img.startsWith('http')) {
            imagePath = img;
          } else if (img.startsWith('/storage/')) {
            imagePath = img;
          } else {
            imagePath = '/storage/' + img;
          }

          if (!images.includes(imagePath)) {
            images.push(imagePath);
          }
        });
      }

      return images;
    },
    currentMainImage() {
      if (this.allImages.length > 0) {
        return this.allImages[this.currentImageIndex];
      }
      return this.product.main_image ? '/storage/' + this.product.main_image : null;
    },
    highlightsList() {
      if (!this.product.highlights) return [];

      try {
        if (typeof this.product.highlights === 'string') {
          return this.product.highlights.split(',').map(h => h.trim()).filter(h => h);
        }
        return Array.isArray(this.product.highlights) ? this.product.highlights : [];
      } catch (e) {
        return [];
      }
    }
  },
  methods: {
    selectColor(colorId) {
      this.selectedColor = colorId;
      this.onColorChange();
    },
    onColorChange() {
      const sizes = this.sizeOptions;
      this.selectedSize = sizes.length ? sizes[0].size_id : null;
      this.selectedImage = null;
      this.currentImageIndex = 0; // Reset to first image when color changes
    },
    onSizeChange() {
      this.selectedImage = null;
    },
    previousImage() {
      if (this.currentImageIndex > 0) {
        this.currentImageIndex--;
      }
    },
    nextImage() {
      if (this.currentImageIndex < this.allImages.length - 1) {
        this.currentImageIndex++;
      }
    },
    setCurrentImage(index) {
      this.currentImageIndex = index;
    },
    capitalizeFirst(text) {
      if (!text) return '';

      // Handle snake_case to Title Case conversion
      return text
        .split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
    },
    updateQty(change) {
      this.quantity = Math.max(1, this.quantity + change);
    },
    addToCart() {
      if (!this.selectedVariant) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Selection',
          text: 'Please select a color and size.'
        });
        return;
      }
      const data = {
        variant_id: this.selectedVariant.variant_id,
        inventory_id: this.selectedColorGroup.inventory_id,
        product_name: this.selectedColorGroup.product_name,
        color_id: this.selectedColorGroup.color_id,
        color_name: this.selectedColorGroup.color_name,
        size_id: this.selectedVariant.size_id,
        size_name: this.selectedVariant.size_name,
        price: this.currentPrice,
        quantity: this.quantity,
        image: this.selectedColorGroup.main_image
      };
      axios.post('/cart/add', data)
        .then(response => {
          Swal.fire({
            icon: 'success',
            title: 'Added to Cart',
            text: 'Added to cart!'
          });
          // Update cart count in the DOM
          if (response.data.cart_count !== undefined) {
            const cartCountEl = document.getElementById('cart-count');
            if (cartCountEl) {
              cartCountEl.textContent = response.data.cart_count;
            }
          }
          // Optionally emit an event or update cart UI
          // this.$emit('cart-updated', response.data.cart);
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to add to cart.'
          });
          console.error(error);
        });
    }
  },
  mounted() {
    if (this.colorOptions.length) {
      this.selectedColor = this.colorOptions[0].color_id;
      this.onColorChange();
    }
  }
};
</script>

<style scoped>
.size-radio-container {
  position: relative;
  cursor: pointer;
  display: inline-block;
}

.size-radio-input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.size-radio-box {
  display: inline-block;
  padding: 8px 16px;
  border: 2px solid #ddd;
  border-radius: 4px;
  background-color: #fff;
  color: #333;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.2s ease;
  min-width: 50px;
  text-align: center;
  user-select: none;
  box-shadow: none !important;
}

.size-radio-input:checked + .size-radio-box {
  border-color: #222121;
  background-color: #222121;
  color: #fff;
}

.size-radio-input:hover + .size-radio-box {
  border-color: #222121;
  background-color: #f8f9fa;
}

.size-radio-input:checked:hover + .size-radio-box {
  background-color: #2b2b2b;
}
.form-check-input:checked[type=radio] {
    --bs-form-check-bg-image: linear-gradient(195deg, #222121 0%, #222121 100%);
}

/* Add to cart button hover effect for atc-dot */
.border-btn:hover .atc-dot {
  background-color: white !important;
}

/* Product Image Slider Styles */
.product-image-slider {
  position: relative;
}

.main-image-container {
  position: relative;
  width: 100%;
  height: 100%;
  margin-bottom: 20px;
  border-radius: 8px;
  overflow: hidden;
  background-color: #ffffff;
}

.main-product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.main-product-image:hover {
  transform: scale(1.05);
}

.slider-nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 10;
}

.slider-nav-btn:hover {
  background: rgba(255, 255, 255, 1);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.slider-nav-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.slider-nav-btn:disabled:hover {
  background: rgba(255, 255, 255, 0.9);
  box-shadow: none;
}

.slider-nav-prev {
  left: 10px;
}

.slider-nav-next {
  right: 10px;
}

.image-counter {
  position: absolute;
  bottom: 10px;
  right: 10px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 500;
}

.thumbnail-container {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  padding: 10px 0;
}

.thumbnail-item {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  border-radius: 6px;
  overflow: hidden;
  cursor: pointer;
  border: 2px solid transparent;
  transition: all 0.3s ease;
}

.thumbnail-item:hover {
  border-color: #222121;
  transform: scale(1.05);
}

.thumbnail-item.active {
  border-color: #222121;
  box-shadow: 0 2px 8px rgba(34, 33, 33, 0.3);
}

.thumbnail-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Price Display Styles */
.product-price-display {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
}

.current-price {
  color: #222121;
  font-weight: 600;
  font-size: 1.2rem;
}

.original-price {
  font-size: 0.9rem;
  color: #6c757d;
}

/* Color Selection Styles */
.color-options {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.color-option {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  border: 2px solid #e9ecef;
  border-radius: 20px;
  background: white;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 0.8rem;
  min-width: fit-content;
}

.color-option:hover {
  border-color: #222121;
  transform: translateY(-1px);
}

.color-option.active {
  border-color: #222121;
  background: #f8f9fa;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.color-dot {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 2px solid #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.color-name {
  font-weight: 500;
  color: #333;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .main-image-container {
    height: 300px;
  }

  .thumbnail-item {
    width: 60px;
    height: 60px;
  }

  .slider-nav-btn {
    width: 35px;
    height: 35px;
  }

  .color-option {
    padding: 4px 8px;
    font-size: 0.75rem;
  }

  .color-dot {
    width: 12px;
    height: 12px;
  }
}

/* Product Details Styles */
.product-short-description {
  border-left: 3px solid #222121;
  padding-left: 15px;
  background-color: #ffffff;
  padding: 15px;
  border-radius: 0 6px 6px 0;
}

.highlights-list {
  list-style: none;
  padding-left: 0;
  margin-bottom: 0;
}

.highlights-list li {
  position: relative;
  padding-left: 20px;
  margin-bottom: 8px;
  color: #555;
}

.highlights-list li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #28a745;
  font-weight: bold;
}

.highlights-list li:last-child {
  margin-bottom: 0;
}

.specs-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 12px;
}

.spec-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 12px;
  background-color: #ffffff;
  border-radius: 6px;
  border-left: 3px solid #222121;
}

.spec-label {
  font-weight: 600;
  color: #333;
  font-size: 14px;
}

.spec-value {
  color: #666;
  font-size: 14px;
  text-align: right;
}

.product-full-description button {
  color: #222121;
  font-weight: 500;
  transition: color 0.3s ease;
}

.product-full-description button:hover {
  color: #000;
}

.full-description-content {
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 6px;
  border-left: 3px solid #222121;
  line-height: 1.6;
}

.care-instructions {
  padding: 15px;
  background-color: #fff3cd;
  border: 1px solid #ffeaa7;
  border-radius: 6px;
}

.care-instructions h6 {
  color: #856404;
  margin-bottom: 8px;
}

.care-instructions p {
  color: #856404;
  margin-bottom: 0;
}

/* Responsive adjustments for product details */
@media (max-width: 768px) {
  .specs-grid {
    grid-template-columns: 1fr;
  }

  .spec-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
  }

  .spec-value {
    text-align: left;
  }
}
</style>
