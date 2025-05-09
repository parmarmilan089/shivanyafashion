<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use App\Models\Products;


class AdminController extends Controller
{
    //
    public function index(){
        $amazonOrderIds = Order::where('sold_on', 'amazon')->pluck('id');
        $amazonSales = DB::table('order_products')
            ->whereIn('order_id', $amazonOrderIds)
            ->sum(DB::raw('price * quantity'));
        $amazonOrderCount = $amazonOrderIds->count();
        $amazonProductCount = Product::where('selling_platform', 'amazon')->count();
        $amazonSellerCount = Product::where('selling_platform', 'amazon')
            ->distinct('seller_name')->count('seller_name');

        // Meesho data
        $meeshoOrderIds = Order::where('sold_on', 'meesho')->pluck('id');
        $meeshoSales = DB::table('order_products')
            ->whereIn('order_id', $meeshoOrderIds)
            ->sum(DB::raw('price * quantity'));
        $meeshoOrderCount = $meeshoOrderIds->count();
        $meeshoProductCount = Product::where('selling_platform', 'meesho')->count();
        $meeshoSellerCount = Product::where('selling_platform', 'meesho')
            ->distinct('seller_name')->count('seller_name');

        return view('admin.dashboard', [
            // Amazon
            'amazonSales' => $amazonSales,
            'amazonOrders' => $amazonOrderCount,
            'amazonProducts' => $amazonProductCount,
            'amazonSellers' => $amazonSellerCount,

            // Meesho
            'meeshoSales' => $meeshoSales,
            'meeshoOrders' => $meeshoOrderCount,
            'meeshoProducts' => $meeshoProductCount,
            'meeshoSellers' => $meeshoSellerCount,
        ]);
    }
}
