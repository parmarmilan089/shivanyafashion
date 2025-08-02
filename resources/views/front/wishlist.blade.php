@extends('front.layout.page')

@section('front-content')
    <div class="container my-5" style="margin-top: 100px !important;">
        <h2 class="mb-4 section-title text-center">My Wishlist</h2>
        <div id="wishlist-products">
            <p>Loading your wishlist...</p>
        </div>
    </div>

    <div v-if="wishlistMessage" id="wishlist-toast" class="wishlist-toast" style="display:none;">
        <span class="wishlist-toast-icon">💖</span>
        <span id="wishlist-toast-msg"></span>
        <button type="button" onclick="document.getElementById('wishlist-toast').style.display='none'"
            style="background:none;border:none;color:#fff;font-size:1.2rem;margin-left:10px;cursor:pointer;">&times;</button>
    </div>

    <style>
        .pro-img {
            object-fit: contain;
            height: 100%;
            width: 100%;
        }

        .product-remove {
            top: 10px;
            background-color: #161616a1;
            right: 10px;
            z-index: 2;
            font-weight: 800;
            border-radius: 30px;
            font-size: 15px;
            padding: 5px;
            height: 20px;
            line-height: 5px;
            color: white;
        }

        .product-remove:hover {
            background-color: #fc5f5f;
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 40px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-items-img {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .product-info {
            padding: 1rem;
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

        .current-price {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .wishlist-toast {
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #f16757 0%, #ffb199 100%);
            color: #fff;
            padding: 8px 18px;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(241, 103, 87, 0.18);
            font-size: 1rem;
            font-weight: 600;
            z-index: 9999;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: auto;
            min-width: unset;
            max-width: 90vw;
            animation: wishlist-fade-in 0.4s;
        }

        .wishlist-toast-icon {
            font-size: 1.5rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.12));
        }

        @keyframes wishlist-fade-in {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    </style>
    <script>
        function limitText(text, limit) {
            if (!text) return '';
            return text.length > limit ? text.slice(0, limit) + '...' : text;
        }

        function showWishlistMessage(msg) {
            const toast = document.getElementById('wishlist-toast');
            const toastMsg = document.getElementById('wishlist-toast-msg');
            toastMsg.textContent = msg;
            toast.style.display = 'inline-flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 2000);
        }

        function removeFromWishlist(id) {
            let wishlist = [];
            const match = document.cookie.match(/(?:^|; )wishlist=([^;]*)/);
            if (match) {
                try {
                    wishlist = JSON.parse(decodeURIComponent(match[1]));
                } catch {
                    wishlist = [];
                }
            }
            wishlist = wishlist.filter(pid => pid != id);
            document.cookie = "wishlist=" + JSON.stringify(wishlist) + "; path=/; max-age=31536000";
            // Store message in sessionStorage
            sessionStorage.setItem('wishlistMessage', 'Product removed from wishlist');
            location.reload();
        }

        document.addEventListener('DOMContentLoaded', function() {
            function getWishlistFromCookie() {
                const match = document.cookie.match(/(?:^|; )wishlist=([^;]*)/);
                if (match) {
                    try {
                        return JSON.parse(decodeURIComponent(match[1]));
                    } catch {
                        return [];
                    }
                }
                return [];
            }

            const wishlistIds = getWishlistFromCookie();
            if (wishlistIds.length === 0) {
                document.getElementById('wishlist-products').innerHTML = '<p>Your wishlist is empty.</p>';
            } else {
                fetch('/api/wishlist-products', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ids: wishlistIds
                        })
                    })
                    .then(res => res.json())
                    .then(response => {
                        const inventories = response.data || [];
                        const variantData = response.variantData || [];
                        if (inventories.length === 0) {
                            document.getElementById('wishlist-products').innerHTML =
                                '<p>No products found.</p>';
                        } else {
                            let html = '<div class="row">';
                            inventories.forEach(product => {
                                const productVariants = variantData.filter(v => v.inventory_id ===
                                    product.id || v.inventory_id === product.inventory_id);
                                let mainImage = product.main_image ? product.main_image : '';
                                let colorName = '';
                                let price = '';
                                let galleryImages = [];
                                if (productVariants.length > 0) {
                                    mainImage = productVariants[0].main_image || mainImage;
                                    colorName = productVariants[0].color_name || '';
                                    colorCode = productVariants[0].color_code || '';
                                    if (productVariants[0].variants && productVariants[0].variants
                                        .length > 0) {
                                        price = productVariants[0].variants[0].sale_price ||
                                            productVariants[0].variants[0].price || '';
                                    }
                                    galleryImages = productVariants[0].gallery_images || [];
                                }
                                html += `<div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                        <div class="product-card h-100 position-relative" data-product-id="${product.id || product.inventory_id}">
                            <button type="button" class="btn btn-sm position-absolute product-remove" style="top:10px;right:10px;z-index:2;font-weight: 900;" onclick="removeFromWishlist('${product.id || product.inventory_id}')">&times;</button>
                            <div class="product-items-img">`;
                                if (galleryImages.length > 0) {
                                    const carouselId =
                                        `carousel-wishlist-${product.id || product.inventory_id}`;
                                    html += `<div id="${carouselId}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">`;
                                    galleryImages.forEach((img, idx) => {
                                        html += `<div class="carousel-item${idx === 0 ? ' active' : ''}">
                                            <img src="/storage/${img}" class="pro-img" alt="${product.product_name || product.name}">
                            </div>`;
                                    });
                                    html += `</div>`;
                                    if (galleryImages.length > 1) {
                                        html += `
                                <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            `;
                                    }
                                    html += `</div>`;
                                } else {
                                    html +=
                                        `<img src="${mainImage}" class="card-img-top" alt="${product.product_name || product.name}">`;
                                }
                                html += `</div>
                            <div class="product-info pt-1">
                                <button type="button" class="color-option active m-auto" title="${colorName}"><span class="color-dot" style="background-color:${colorCode};"></span></button>
                                <h5 class="product-title">${limitText(product.product_name || product.name, 40)}</h5>
                                <p class="current-price">₹${price}</p>
                                <a href="/product/${product.id || product.inventory_id}" class="border-btn flex-1">View Details</a>
                            </div>
                        </div>
                    </div>`;
                            });
                            html += '</div>';
                            document.getElementById('wishlist-products').innerHTML = html;
                        }
                    });
            }

            // Show message if present in sessionStorage
            const msg = sessionStorage.getItem('wishlistMessage');
            if (msg) {
                showWishlistMessage(msg);
                sessionStorage.removeItem('wishlistMessage');
            }
        });
    </script>
@endsection
