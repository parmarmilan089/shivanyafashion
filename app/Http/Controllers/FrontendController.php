<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\ProductVariant;

class FrontendController extends Controller
{
    //
    public function home()
    {
        // here base on inventories
        $inventories = Inventory::with(['variants.color', 'variants.size'])->limit(20)->orderBy('id', 'desc')->get();
        $featuredProducts = Inventory::with(['variants.color', 'variants.size'])->where('is_featured', 1)->get();
        $variantData = $featuredProducts->flatMap(function($inventory) {
            // Group variants by color_id
            $variantsByColor = $inventory->variants->groupBy('color_id');

            return $variantsByColor->map(function($colorVariants, $colorId) use ($inventory) {
                $firstVariant = $colorVariants->first();
                $color = $firstVariant->color;

                                return [
                    'color_id' => $colorId,
                    'color_name' => optional($color)->name,
                    'color_code' => optional($color)->code,
                    'inventory_id' => $inventory->id,
                    'product_name' => $inventory->name,
                    'main_image' => $firstVariant->main_image ? asset('storage/' . $firstVariant->main_image) :
                                   ($inventory->main_image ? asset('storage/' . $inventory->main_image) : null),
                    'gallery_images' => $firstVariant->gallery_images,
                    'variants' => $colorVariants->map(function($v) {
                        return [
                            'variant_id' => $v->id,
                            'size_id' => optional($v->size)->id,
                            'size_name' => optional($v->size)->name,
                            'price' => $v->price,
                            'sale_price' => $v->sale_price,
                            'stock_qty' => $v->stock_qty,
                        ];
                    })->values()
                ];
            });
        })->values();
        $categorys = Category::where('category_type', 1)->get();
        return view('home', compact('inventories', 'categorys', 'variantData'));
    }

    public function product($id)
    {
        $product = Inventory::with(['variants.color', 'variants.size'])->findOrFail($id);
        $variantData = $product->variants->groupBy('color_id')->map(function($colorVariants, $colorId) use ($product) {
            $firstVariant = $colorVariants->first();
            $color = $firstVariant->color;

                        return [
                'color_id' => $colorId,
                'color_name' => optional($color)->name,
                'color_code' => optional($color)->code,
                'inventory_id' => $product->id,
                'product_name' => $product->name,
                'main_image' => $firstVariant->main_image ? asset('storage/' . $firstVariant->main_image) :
                               ($product->main_image ? asset('storage/' . $product->main_image) : null),
                'gallery_images' => $firstVariant->gallery_images,
                'variants' => $colorVariants->map(function($v) {
                    return [
                        'variant_id' => $v->id,
                        'size_id' => optional($v->size)->id,
                        'size_name' => optional($v->size)->name,
                        'price' => $v->price,
                        'sale_price' => $v->sale_price,
                        'stock_qty' => $v->stock_qty,
                    ];
                })->values()
            ];
        })->values();

        // Get related products based on category, pattern, type, color, fabric
        $relatedProducts = Inventory::with(['variants.color', 'variants.size'])
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('subcategory_id', $product->subcategory_id)
                      ->orWhere('subsubcategory_id', $product->subsubcategory_id)
                      ->orWhere('pattern', $product->pattern)
                      ->orWhere('fabric', $product->fabric)
                      ->orWhere('fit', $product->fit)
                      ->orWhere('neck_style', $product->neck_style)
                      ->orWhere('sleeve_type', $product->sleeve_type);
            })
            ->limit(10)
            ->get();

        return view('front.product-details', compact('product', 'variantData', 'relatedProducts'));
    }

    public function categoryPage($slug, Request $request)
    {
        // Get the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Query inventories that belong to this category
        $query = Inventory::where('category_id', $category->id);

        // Eager load variants with filters applied
        $query->with(['variants' => function ($q) use ($request) {
            if ($request->filled('color')) {
                $q->where('color_id', $request->color);
            }
            if ($request->filled('min_price')) {
                $q->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $q->where('price', '<=', $request->max_price);
            }
        }]);

        // Optionally filter inventories to include only those that have variants matching filters
        if ($request->filled('color') || $request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                if ($request->filled('color')) {
                    $q->where('color_id', $request->color);
                }
                if ($request->filled('min_price')) {
                    $q->where('price', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price', '<=', $request->max_price);
                }
            });
        }

        $inventories = $query->paginate(12);

        $colors = Color::all();

        $minPrice = ProductVariant::min('price');
        $maxPrice = ProductVariant::max('price');

        return view('front.category', compact('category', 'inventories', 'colors', 'minPrice', 'maxPrice'));
    }

    /**
     * Capitalize first letter and convert snake_case to Title Case
     */
    private function capitalizeFirst($text)
    {
        if (empty($text)) return '';

        // Handle snake_case to Title Case conversion
        return ucwords(str_replace('_', ' ', strtolower($text)));
    }

    public function products($categoryId, Request $request)
    {
        // Validate and cast input filters
        $color = $request->input('color', null);
        $minPrice = $request->input('min_price', null);
        $maxPrice = $request->input('max_price', null);

        // Query inventories that belong to this category
        $query = Inventory::where('category_id', $categoryId);

        // Eager load variants with filters if they exist
        $query->with(['variants' => function ($q) use ($color, $minPrice, $maxPrice) {
            if ($color !== null && $color !== '') {
                $q->where('color_id', $color);
            }
            if ($minPrice !== null && is_numeric($minPrice)) {
                $q->where('price', '>=', $minPrice);
            }
            if ($maxPrice !== null && is_numeric($maxPrice)) {
                $q->where('price', '<=', $maxPrice);
            }
        }]);

        // Filter inventories having variants matching the variant filters
        if (($color !== null && $color !== '') || ($minPrice !== null) || ($maxPrice !== null)) {
            $query->whereHas('variants', function ($q) use ($color, $minPrice, $maxPrice) {
                if ($color !== null && $color !== '') {
                    $q->where('color_id', $color);
                }
                if ($minPrice !== null && is_numeric($minPrice)) {
                    $q->where('price', '>=', $minPrice);
                }
                if ($maxPrice !== null && is_numeric($maxPrice)) {
                    $q->where('price', '<=', $maxPrice);
                }
            });
        }

        // Paginate results, 12 per page (same as categoryPage)
        $inventories = $query->paginate(12);

        // Return paginated data as JSON (you can customize which fields to include)
        return response()->json($inventories);
    }
}
