<template>
  <div>
    <div class="mb-3">
      <label class="form-label d-block">Color:</label>
      <div class="d-flex gap-3">
        <label v-for="color in colorOptions" :key="color.color_id" class="form-check-label d-flex align-items-center gap-2">
          <input
            type="radio"
            class="form-check-input"
            :value="color.color_id"
            v-model="selectedColor"
            @change="onColorChange"
          >
          <span :style="{ display: 'inline-block', width: '20px', height: '20px', borderRadius: '50%', backgroundColor: color.color_code, border: '1px solid #ccc' }"
            :title="color.color_name"
          ></span>
          {{ color.color_name }}
        </label>
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
      <span class="product-title d-block">
        ₹{{ selectedVariant ? selectedVariant.price : 'N/A' }}
      </span>
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
</template>

<script>
import axios from 'axios';
export default {
  name: 'ProductOptions',
  props: {
    variants: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedColor: null,
      selectedSize: null,
      quantity: 1
    };
  },
  computed: {
    colorOptions() {
      const map = {};
      this.variants.forEach(v => {
        if (v.color_id && !map[v.color_id]) {
          map[v.color_id] = { color_id: v.color_id, color_name: v.color_name, color_code: v.color_code };
        }
      });
      return Object.values(map);
    },
    sizeOptions() {
      return this.variants.filter(v => v.color_id === this.selectedColor);
    },
    selectedVariant() {
      return this.variants.find(
        v => v.color_id === this.selectedColor && v.size_id === this.selectedSize
      );
    },
    totalPrice() {
      return this.selectedVariant ? (this.selectedVariant.price * this.quantity) : 0;
    }
  },
  methods: {
    onColorChange() {
      const sizes = this.sizeOptions;
      this.selectedSize = sizes.length ? sizes[0].size_id : null;
    },
    onSizeChange() {
      // Placeholder for logic if needed later
    },
    updateQty(change) {
      this.quantity = Math.max(1, this.quantity + change);
    },
    addToCart() {
      if (!this.selectedVariant) {
        alert('Please select a color and size.');
        return;
      }
      const data = {
        variant_id: this.selectedVariant.variant_id,
        inventory_id: this.selectedVariant.inventory_id,
        product_name: this.selectedVariant.product_name,
        color_id: this.selectedVariant.color_id,
        color_name: this.selectedVariant.color_name,
        size_id: this.selectedVariant.size_id,
        size_name: this.selectedVariant.size_name,
        price: this.selectedVariant.price,
        quantity: this.quantity,
        image: this.selectedVariant.image
      };
      axios.post('/cart/add', data)
        .then(response => {
          alert('Added to cart!');
          // Optionally emit an event or update cart UI
          // this.$emit('cart-updated', response.data);
        })
        .catch(error => {
          alert('Failed to add to cart.');
          console.error(error);
        });
    }
  },
  mounted() {
    console.log(this.variants,'variants');

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
</style>
