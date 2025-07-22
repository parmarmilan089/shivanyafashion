<template>
  <div>
    <div class="row mb-4">
      <div class="col-md-3">
        <h5>Filters</h5>
        <div class="mb-3">
          <label>Price Range</label>
          <input type="range" :min="minPrice" :max="maxPrice" v-model="filters.min_price" @change="fetchProducts">
          <input type="range" :min="minPrice" :max="maxPrice" v-model="filters.max_price" @change="fetchProducts">
          <div>₹{{ filters.min_price }} - ₹{{ filters.max_price }}</div>
        </div>
        <div class="mb-3">
          <label>Color</label>
          <select v-model="filters.color" @change="fetchProducts" class="form-control">
            <option value="">All</option>
            <option v-for="color in colors" :key="color.id" :value="color.id">{{ color.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-9">
        <div class="row">
          <div v-for="product in products.data" :key="product.id" class="col-md-4 mb-4">
            <div class="card h-100">
              <img :src="product.image" class="card-img-top" :alt="product.name">
              <div class="card-body">
                <h5 class="card-title">{{ product.name }}</h5>
                <p class="card-text">₹{{ product.price }}</p>
                <a :href="'/product/' + product.id" class="btn btn-primary">View</a>
              </div>
            </div>
          </div>
        </div>
        <nav v-if="products.last_page > 1">
          <ul class="pagination">
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
  props: {
    categoryId: Number,
    colors: Array,
    minPrice: Number,
    maxPrice: Number,
    initialProducts: Object
  },
  data() {
    return {
      filters: {
        color: '',
        min_price: this.minPrice,
        max_price: this.maxPrice
      },
      products: this.initialProducts
    };
  },
  methods: {
    fetchProducts(page = 1) {
      const params = {
        color: this.filters.color,
        min_price: this.filters.min_price,
        max_price: this.filters.max_price,
        page
      };
      axios.get(`/api/category/${this.categoryId}/products`, { params })
        .then(res => {
          this.products = res.data;
        });
    },
    changePage(page) {
      if (page < 1 || page > this.products.last_page) return;
      this.fetchProducts(page);
    }
  }
};
</script>
