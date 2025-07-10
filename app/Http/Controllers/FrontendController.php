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
        return view('front.product-details', compact('product'));
    }
}
