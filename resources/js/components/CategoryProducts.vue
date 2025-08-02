<template>
    <div class="container my-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <aside class="col-md-3 mb-4">
                <h5 class="mb-3">Filters</h5>

                <!-- Price Range with Two Native Inputs (No Slider) -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Price Range</label>
                    <div class="d-flex align-items-center mb-2">
                        <input type="number" :min="minPrice" :max="filters.max_price" v-model.number="filters.min_price"
                            @change="onInputPriceChange" class="form-control me-2" style="flex:1;" placeholder="Min" />
                        <span class="mx-2">to</span>
                        <input type="number" :min="filters.min_price" :max="maxPrice" v-model.number="filters.max_price"
                            @change="onInputPriceChange" class="form-control ms-2" style="flex:1;" placeholder="Max" />
                    </div>
                </div>

                <!-- Color Selector -->
                <div class="mb-4">
                    <label for="colorFilter" class="form-label fw-semibold">Color</label>
                    <select id="colorFilter" v-model="filters.color" @change="fetchProducts" class="form-select">
                        <option value="">All Colors</option>
                        <option v-for="color in colors" :key="color.id" :value="color.id">
                            {{ color.name }}
                        </option>
                    </select>
                </div>

                <!-- Reset Filters Button -->
                <button class="btn btn-outline-secondary w-100" @click="resetFilters"
                    :disabled="!filters.color && filters.min_price === minPrice && filters.max_price === maxPrice">
                    Reset Filters
                </button>
            </aside>

            <!-- Products Grid -->
            <section class="col-md-9">
                <div class="row g-4">
                    <div v-for="product in products || []" :key="product.inventory_id" class="col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm product-card">
                            <img :src="variantImage(product)" class="card-img-top" :alt="product.product_name"
                                style="object-fit: cover; height: 300px; width: 100%;" />
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title  ">{{ product.product_name }}</h5>

                                <p class="card-text fw-bold fs-5 ">₹{{ variantPrice(product) }}</p>
                                <div class="">
                                    <label class="form-label d-block">Color:</label>
                                    <div class="color-options d-flex gap-2 flex-wrap">
                                        <button v-for="color in variantColor(product)" :key="color.color_id" type="button"
                                            class="color-option" :class="{ 'active': selectedColor === color.color_id }"
                                            @click="selectColor(color.color_id)" :title="color.color_name">
                                            <span class="color-dot"
                                                :style="{ backgroundColor: color.color_code || '#ccc' }"></span>
                                            <span class="color-name">{{ color.color_name }}</span>
                                        </button>
                                    </div>
                                </div>
                                <a :href="`/product/${product.id}`" class="border-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav v-if="products.last_page > 1" aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li :class="['page-item', { disabled: products.current_page === 1 }]">
                            <button class="page-link" @click="changePage(products.current_page - 1)"
                                aria-label="Previous" :disabled="products.current_page === 1">
                                &laquo; Previous
                            </button>
                        </li>
                        <li v-for="page in products.last_page" :key="page"
                            :class="['page-item', { active: products.current_page === page }]">
                            <button class="page-link" @click="changePage(page)">{{ page }}</button>
                        </li>
                        <li :class="['page-item', { disabled: products.current_page === products.last_page }]">
                            <button class="page-link" @click="changePage(products.current_page + 1)" aria-label="Next"
                                :disabled="products.current_page === products.last_page">
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
import axios from "axios";

export default {
    props: {
        categoryId: { type: Number, required: true },
        colors: { type: Array, required: true },
        minPrice: { type: Number, required: true },
        maxPrice: { type: Number, required: true },
        initialProducts: { type: Object, required: true },
        baseUrl: { type: String, required: true },
    },
    data() {
        return {
            filters: {
                color: "",
                min_price: this.minPrice,
                max_price: this.maxPrice,
            },
            products: this.initialProducts,
        };
    },
    methods: {
        fetchProducts(page = 1) {
            if (this.filters.min_price > this.filters.max_price) {
                console.warn("Min price is greater than max price. Adjusting filters.");
                [this.filters.min_price, this.filters.max_price] = [this.filters.max_price, this.filters.min_price];
            }
            axios
                .get(`/api/category/${this.categoryId}/products`, {
                    params: {
                        color: this.filters.color,
                        min_price: this.filters.min_price,
                        max_price: this.filters.max_price,
                        page,
                    },
                })
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
            this.filters.color = "";
            this.filters.min_price = this.minPrice;
            this.filters.max_price = this.maxPrice;
            this.fetchProducts(1);
        },
        variantImage(product) {
            if (product.colors && product.colors.length > 0 && product.colors[0].main_image) {
                return product.colors[0].main_image;
            }
            return this.baseUrl + 'images/default-product.png';
        },
        variantColor(product) {
            // console.log(product,'product');

        },
        variantPrice(product) {
            if (!product.colors || product.colors.length === 0) return 'N/A';

            const variant = product.colors[0].variants[0];
            console.log(variant,'variant');


            // Fallback to price if no sale info
            if (!variant.sale_start_date || !variant.sale_end_date || !variant.sale_price) {
                return variant.price;
            }

            const now = new Date();
            const start = new Date(variant.sale_start_date);
            const end = new Date(variant.sale_end_date);

            // Check if current date is within the sale window
            const isOnSale = now >= start && now <= end;

            return isOnSale ? variant.sale_price : variant.price;
        },
        onInputPriceChange() {
            // Prevent min exceeding max and vice versa
            if (this.filters.min_price > this.filters.max_price) {
                [this.filters.min_price, this.filters.max_price] = [this.filters.max_price, this.filters.min_price];
            }
            // Clamp to allowed range
            if (this.filters.min_price < this.minPrice) this.filters.min_price = this.minPrice;
            if (this.filters.max_price > this.maxPrice) this.filters.max_price = this.maxPrice;
            this.fetchProducts(1);
        },
    },
    mounted() {
        console.log(this.products,'sdfsdf');

        this.fetchProducts();
        // console.log(this.products,'sdfsdf afterrer');

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

.product-title {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.4;
    height: 2.8rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
