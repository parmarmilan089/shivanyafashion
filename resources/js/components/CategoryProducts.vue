<template>
  <div>
    <div class="row mb-4">
      <div class="col-md-3 filter-sidebar">
        <h4 class="mb-4 filter-title">Filters</h4>
        <div class="mb-4">
          <label class="form-label">Price Range</label>
          <div class="d-flex align-items-center mb-2">
            <input type="range" :min="category.minPrice" :max="category.maxPrice" v-model="filters.min_price" @change="fetchProducts" class="form-range me-2">
            <input type="range" :min="category.minPrice" :max="category.maxPrice" v-model="filters.max_price" @change="fetchProducts" class="form-range">
          </div>
          <div class="price-range">₹{{ filters.min_price }} - ₹{{ filters.max_price }}</div>
        </div>
        <div class="mb-4">
          <label class="form-label">Color</label>
          <select v-model="filters.color" @change="fetchProducts" class="form-select">
            <option value="">All</option>
            <option v-for="color in category.colors" :key="color.id" :value="color.id">
              {{ color.name }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-md-8">
        <div v-if="loading" class="text-center my-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        <div v-else class="row">
          <div v-for="product in products.data" :key="product.id" class="col-md-5 mb-4">
            <div class="card product-card h-100 shadow-sm">
              <img :src="`/storage/${product.main_image}`" class="card-img-top product-img" :alt="product.name">
              <div class="card-body d-flex flex-column">
                <h5 class="product-title mb-3">{{ product.name }}</h5>
                <p class="card-text mb-2">₹{{ product.price }}</p>
                <a :href="'/product/' + product.id" class="btn btn-primary mt-auto">View</a>
              </div>
            </div>
          </div>
        </div>
        <nav v-if="products.last_page > 1 && !loading">
          <ul class="pagination justify-content-center mt-4">
            <li class="page-item" :class="{disabled: products.current_page === 1}">
              <a class="page-link" href="#" @click.prevent="changePage(products.current_page - 1)">Previous</a>
            </li>
            <li class="page-item" v-for="page in products.last_page" :key="page" :class="{active: products.current_page === page}">
              <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{disabled: products.current_page === products.last_page}">
              <a class="page-link" href="#" @click.prevent="changePage(products.current_page + 1)">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "CategoryProducts",
  props: {
    category: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      filters: {
        color: '',
        min_price: this.category.minPrice,
        max_price: this.category.maxPrice
      },
      products: this.category.products,
      loading: false
    };
  },
  mounted() {
    console.log("Category data received:", this.category);
  },
  methods: {
    fetchProducts(page = 1) {
      this.loading = true;
      const params = {
        color: this.filters.color,
        min_price: this.filters.min_price,
        max_price: this.filters.max_price,
        page
      };
      axios.get(`/api/category/${this.category.categoryId}/products`, { params })
        .then(res => {
          this.products = res.data;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    changePage(page) {
      if (page < 1 || page > this.products.last_page) return;
      this.fetchProducts(page);
    }
  }
};
</script>

<style scoped>
.filter-sidebar {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 24px 16px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.filter-title {
  font-weight: 600;
  color: #333;
}
.form-label {
  font-size: 1rem;
  font-weight: 500;
}
.price-range {
  font-size: 1.1rem;
  color: #007bff;
  font-weight: 500;
}
.product-card {
  transition: box-shadow 0.2s, transform 0.2s;
  border: none;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
}
.product-card:hover {
  box-shadow: 0 8px 24px rgba(0,123,255,0.12), 0 1.5px 4px rgba(0,0,0,0.08);
  transform: translateY(-4px) scale(1.02);
}
.product-img {
  object-fit: cover;
  height: 220px;
  border-top-left-radius: 12px;
  border-top-right-radius: 12px;
}
.card-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #222;
}
.card-text {
  color: #28a745;
  font-size: 1.05rem;
  font-weight: 500;
}
.btn-primary {
  background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
  border: none;
  border-radius: 6px;
  font-weight: 500;
  transition: background 0.2s;
}
.btn-primary:hover {
  background: linear-gradient(90deg, #0056b3 0%, #007bff 100%);
}
.pagination .page-link {
  color: #007bff;
  border-radius: 6px;
  margin: 0 2px;
}
.pagination .page-item.active .page-link {
  background: #007bff;
  color: #fff;
  border: none;
}
.spinner-border {
  width: 3rem;
  height: 3rem;
}
</style>
