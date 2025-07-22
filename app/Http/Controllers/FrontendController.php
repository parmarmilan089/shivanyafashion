<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Inventory;

class FrontendController extends Controller
{
    //
    public function home()
    {
        // here base on inventories
        $inventories = \App\Models\Inventory::with(['variants.color', 'variants.size'])->limit(20)->orderBy('id', 'desc')->get();
        $categorys = Category::where('category_type', 1)->get();
        return view('home', compact('inventories', 'categorys'));
    }

    public function product($id)
    {
        $product = \App\Models\Inventory::with(['variants.color', 'variants.size'])->findOrFail($id);
        $variantData = $product->variants->map(function($v) use ($product) {
            return [
                'variant_id' => $v->id,
                'inventory_id' => $v->inventory_id,
                'product_name' => $product->name,
                'color_id' => optional($v->color)->id,
                'color_name' => optional($v->color)->name,
                'size_id' => optional($v->size)->id,
                'size_name' => optional($v->size)->name,
                'price' => $v->price,
                'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
            ];
        })->values();
        return view('front.product-details', compact('product', 'variantData'));
    }

    public function categoryPage($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Inventory::with(['variants'])->where('category_id', $category->id);
        // Only filter by price if min_price or max_price is present
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('variants', function($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('price', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price', '<=', $request->max_price);
                }
            });
        }

        // Filter by color if present
        if ($request->filled('color')) {
            $query->whereHas('variants', function($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }
        $products = $query->paginate(12);
        $colors = Color::all();
        $minPrice = \App\Models\ProductVariant::where('inventory_id', $products->first()->id)->min('price');
        $maxPrice = \App\Models\ProductVariant::where('inventory_id', $products->first()->id)->max('price');
        return view('front.category', compact('category', 'products', 'colors', 'minPrice', 'maxPrice'));
    }
}
