<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;


class FrontendController extends Controller
{
    //
    public function home(){
        $products = Product::limit(20)->orderBy('id','desc')->get();
        $categorys = Category::where('category_type',1)->get();
        return view('home',compact('products','categorys'));
    }

    public function product($id){
        $product = Product::find($id);
        return view('front.product-details',compact('product'));
    }
}
