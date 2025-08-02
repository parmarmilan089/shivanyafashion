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
                    <div v-for="product in products" :key="product.inventory_id" class="col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm product-card">
                            <!-- Image Slider -->
                            <div v-if="currentGallery(product).length > 0" :id="'carousel-' + product.inventory_id"
                                class="carousel slide">
                                <div class="carousel-inner">
                                    <div v-for="(img, idx) in currentGallery(product)" :key="img"
                                        :class="['carousel-item', { active: idx === 0 }]">
                                        <img :src="baseUrl + '/' + img" :alt="product.product_name"
                                            style="object-fit: contain; height: 300px; width: 100%;" />
                                    </div>
                                </div>
                                <button v-if="currentGallery(product).length > 1" class="carousel-control-prev"
                                    type="button" :data-bs-target="'#carousel-' + product.inventory_id"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button v-if="currentGallery(product).length > 1" class="carousel-control-next"
                                    type="button" :data-bs-target="'#carousel-' + product.inventory_id"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            <img v-else :src="variantImage(product)" class="card-img-top" :alt="product.product_name"
                                style="object-fit: contain; height: 300px; width: 100%;" />

                            <div class="card-body d-flex flex-column pt-2">
                                <div>
                                    <div class="color-options d-flex gap-2 flex-wrap justify-content-center">
                                        <button
                                            v-for="color in variantColor(product)"
                                            :key="color.color_id"
                                            type="button"
                                            class="color-option"
                                            :class="{ 'active': selectedColors[product.inventory_id] === color.color_id }"
                                            @click="onColorChange(product, color.color_id)"
                                            :title="color.color_name"
                                        >
                                            <span class="color-dot" :style="{ backgroundColor: color.color_code || '#ccc' }"></span>
                                        </button>
                                    </div>
                                </div>
                                <h5 class="product-title">{{ limitText(product.product_name, 20) }}</h5>
                                <p class="card-text fw-bold fs-5 m-0">₹{{ variantPrice(product) }}</p>
                                <a
  :href="`/product/${product.inventory_id}`"
  class="border-btn"
  rel="noopener"
  :title="`View details for ${limitText(product.product_name, 20)}`"
>
  View Details
</a>
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
            selectedColors: {}, // Track selected color per product
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
                    this.products = Array.isArray(res.data) ? res.data : (res.data.data || []);

                    this.$nextTick(() => {
                        const productList = Array.isArray(this.products) ? this.products : (this.products.data || []);
                        productList.forEach(product => {
                            if (product && !this.selectedColors[product.inventory_id] && product.grouped_variants && product.grouped_variants.length > 0) {
                                this.selectedColors[product.inventory_id] = product.grouped_variants[0].color_id;
                            }
                        });
                    });
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
        variantColor(product) {
            return product.grouped_variants || [];
        },
        onColorChange(product, colorId) {
            this.selectedColors[product.inventory_id] = colorId;
            this.$nextTick(() => {
                const carousel = document.getElementById('carousel-' + product.inventory_id);
                if (carousel && window.bootstrap) {
                    const bsCarousel = window.bootstrap.Carousel.getInstance(carousel) || new window.bootstrap.Carousel(carousel);
                    bsCarousel.to(0);
                }
            });
        },
        currentGallery(product) {
            // Get gallery images for selected color, fallback to first color, else empty
            const colorId = this.selectedColors[product.inventory_id];
            let colorObj = (product.grouped_variants || []).find(c => c.color_id === colorId);

            if (!colorObj && product.grouped_variants && product.grouped_variants.length > 0) {
                colorObj = product.grouped_variants[0];
            }
            return colorObj && colorObj.gallery_images ? colorObj.gallery_images : [];
        },
        variantImage(product) {
            if (product.grouped_variants && product.grouped_variants.length > 0 && product.grouped_variants[0].main_image) {
                return this.baseUrl + product.grouped_variants[0].main_image;
            }
            return this.baseUrl + 'images/default-product.png';
        },
        variantPrice(product) {
            if (!product.grouped_variants || product.grouped_variants.length === 0) return 'N/A';

            // Get selected color id for this product
            const selectedColorId = this.selectedColors[product.inventory_id];
            // Find the selected color group
            let colorGroup = (product.grouped_variants || []).find(c => c.color_id === selectedColorId);
            if (!colorGroup) colorGroup = product.grouped_variants[0];

            // Get the first variant for that color
            const variant = colorGroup.variants && colorGroup.variants[0];
            if (!variant) return 'N/A';

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
        limitText(text, limit) {
            if (!text) return '';
            return text.length > limit ? text.slice(0, limit) + '...' : text;
        },
    },
    mounted() {
        this.fetchProducts();
    },
    // beforeMount() {
    //     this.fetchProducts();
    // },
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
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;

}
</style>
