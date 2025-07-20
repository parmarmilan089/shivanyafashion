<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
}
