<template>
    <div class="container my-5">
      <div class="row">
        <!-- Filters Sidebar -->
        <aside class="col-md-3 mb-4">
          <h5 class="mb-3">Filters</h5>

          <!-- Price Range -->
          <div class="mb-4">
            <label class="form-label fw-semibold">Price Range</label>
            <div class="d-flex align-items-center mb-2">
              <input
                type="range"
                :min="minPrice"
                :max="maxPrice"
                v-model.number="filters.min_price"
                @change="fetchProducts"
                class="form-range me-2"
                style="flex: 1"
              />
              <span class="text-muted">₹{{ filters.min_price }}</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <input
                type="range"
                :min="minPrice"
                :max="maxPrice"
                v-model.number="filters.max_price"
                @change="fetchProducts"
                class="form-range me-2"
                style="flex: 1"
              />
              <span class="text-muted">₹{{ filters.max_price }}</span>
            </div>
            <div class="small text-secondary">
              Price between ₹{{ minPrice }} and ₹{{ maxPrice }}
            </div>
          </div>

          <!-- Color Selector -->
          <div class="mb-4">
            <label for="colorFilter" class="form-label fw-semibold">Color</label>
            <select
              id="colorFilter"
              v-model="filters.color"
              @change="fetchProducts"
              class="form-select"
            >
              <option value="">All Colors</option>
              <option v-for="color in colors" :key="color.id" :value="color.id">
                {{ color.name }}
              </option>
            </select>
          </div>

          <!-- Reset Filters Button -->
          <button
            class="btn btn-outline-secondary w-100"
            @click="resetFilters"
            :disabled="!filters.color && filters.min_price === minPrice && filters.max_price === maxPrice"
          >
            Reset Filters
          </button>
        </aside>

        <!-- Products Grid -->
        <section class="col-md-9">
          <div class="row g-4">
            <div v-for="product in products" :key="product.id" class="col-sm-6 col-lg-4">
              <div class="card h-100 shadow-sm product-card">
                <img
                  :src="variantImage(product)"
                  class="card-img-top"
                  :alt="product.name"
                  style="object-fit: cover; height: 200px;"
                />
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ product.name }}</h5>
                  <p class="card-text fw-bold fs-5 mb-3">₹{{ variantPrice(product) }}</p>
                  <a :href="`/product/${product.id}`" class="btn btn-primary mt-auto">View Details</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <nav v-if="products.last_page > 1" aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
              <li :class="['page-item', { disabled: products.current_page === 1 }]">
                <button
                  class="page-link"
                  @click="changePage(products.current_page - 1)"
                  aria-label="Previous"
                  :disabled="products.current_page === 1"
                >
                  &laquo; Previous
                </button>
              </li>

              <li
                v-for="page in products.last_page"
                :key="page"
                :class="['page-item', { active: products.current_page === page }]"
              >
                <button class="page-link" @click="changePage(page)">{{ page }}</button>
              </li>

              <li :class="['page-item', { disabled: products.current_page === products.last_page }]">
                <button
                  class="page-link"
                  @click="changePage(products.current_page + 1)"
                  aria-label="Next"
                  :disabled="products.current_page === products.last_page"
                >
                  Next &raquo;
                </button>
              </li>
            </ul>
          </nav>
        </section>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      categoryId: { type: Number, required: true },
      colors: { type: Array, required: true },
      minPrice: { type: Number, required: true },
      maxPrice: { type: Number, required: true },
      initialProducts: { type: Object, required: true }, // Expect paginated response object
    },
    data() {
      return {
        filters: {
          color: '',
          min_price: this.minPrice,
          max_price: this.maxPrice,
        },
        products: this.initialProducts,
      };
    },
    methods: {
      fetchProducts(page = 1) {
        const params = {
          color: this.filters.color,
          min_price: this.filters.min_price,
          max_price: this.filters.max_price,
          page,
        };
        axios
          .get(`/api/category/${this.categoryId}/products`, { params })
          .then((res) => {
            this.products = res.data;
          })
          .catch((error) => {
            console.error("Failed to fetch products:", error);
          });
      },
      changePage(page) {
        if (page < 1 || page > this.products.last_page) return;
        this.fetchProducts(page);
      },
      resetFilters() {
        this.filters.color = '';
        this.filters.min_price = this.minPrice;
        this.filters.max_price = this.maxPrice;
        this.fetchProducts(1);
      },
      variantImage(product) {
        if (
          product.variants &&
          product.variants.length > 0 &&
          product.variants[0].main_image
        ) {
          return '/' + product.variants[0].main_image; // prepend slash or use full URL as needed
        }
        return '/images/default-product.png'; // fallback image path
      },
      variantPrice(product) {
        if (product.variants && product.variants.length > 0) {
          const variant = product.variants[0];
          return variant.sale_price || variant.price || 'N/A';
        }
        return 'N/A';
      },
    },
    mounted() {
      console.log('Category ID:', this.categoryId);
      console.log('Colors:', this.colors);
      console.log('Initial Products:', this.initialProducts);
    },
  };
  </script>

  <style scoped>
  .product-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }
  </style>
