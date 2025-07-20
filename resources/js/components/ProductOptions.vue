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
      <label for="sizeSelect" class="form-label">Size:</label>
      <select v-model="selectedSize" id="sizeSelect" class="form-select" @change="onSizeChange">
        <option v-for="size in sizeOptions" :key="size.size_id" :value="size.size_id">
          {{ size.size_name }}
        </option>
      </select>
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
      <button class="w-100 flex-1 border-btn">Add to Cart</button>
    </div>

    <div class="mb-2">
      <span class="product-title">Total: ₹{{ totalPrice }}</span>
    </div>
  </div>
</template>

<script>
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
