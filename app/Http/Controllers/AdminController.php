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
    public function index()
    {
        // Existing Amazon block...
        $amazonOrderIds = Order::where('sold_on', 'amazon')->pluck('id');

        $amazonSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $amazonOrderIds)
            ->whereIn('orders.order_status', ['Delivered'])
            ->sum(DB::raw('order_products.price * order_products.quantity'));

        $amazonOrderCount = $amazonOrderIds->count();
        $amazonProductCount = Product::where('selling_platform', 'amazon')->count();
        $amazonSellerCount = Product::where('selling_platform', 'amazon')
            ->distinct('seller_name')->count('seller_name');

        // ✅ Amazon Returns
        $amazonReturns = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $amazonOrderIds)
            ->where('orders.order_status', 'Returned')
            ->sum(DB::raw('order_products.price * order_products.quantity'));

        // ✅ Amazon Return Count
        $amazonReturnCount = Order::where('sold_on', 'amazon')
            ->where('order_status', 'Returned')
            ->count();

        // ✅ Amazon Base Returns
        $amazonBaseReturns = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $amazonOrderIds)
            ->where('orders.order_status', 'Returned')
            ->sum(DB::raw('order_products.base_price * order_products.quantity'));

        // ✅ Amazon Base Sales
        $amazonBaseSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $amazonOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('order_products.base_price * order_products.quantity'));

        // Meesho data
        $meeshoOrderIds = Order::where('sold_on', 'meesho')->pluck('id');
        $meeshoSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('order_products.price * order_products.quantity'));
        $meeshoReturns = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Returned') // Adjust if needed
            ->sum(DB::raw('order_products.price * order_products.quantity'));
        $meeshoOrderCount = $meeshoOrderIds->count();
        $meeshoProductCount = Product::where('selling_platform', 'meesho')->count();
        $meeshoSellerCount = Product::where('selling_platform', 'meesho')
            ->distinct('seller_name')->count('seller_name');

        // Return orders count
        $meeshoReturnCount = Order::where('sold_on', 'meesho')
            ->where('order_status', 'Returned') // again, adjust if needed
            ->count();

        // Meesho base returns
        $meeshoBaseReturns = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Returned')
            ->sum(DB::raw('order_products.base_price * order_products.quantity'));

        // Meesho base sales based on base_price
        $meeshoBaseSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('order_products.base_price * order_products.quantity'));

        return view('admin.dashboard', [
            // Amazon
            'amazonSales' => $amazonSales,
            'amazonOrders' => $amazonOrderCount,
            'amazonProducts' => $amazonProductCount,
            'amazonSellerCount' => $amazonSellerCount,
            'amazonReturns' => $amazonReturns,
            'amazonReturnCount' => $amazonReturnCount,
            'amazonBaseSales' => $amazonBaseSales,
            'amazonBaseReturns' => $amazonBaseReturns,
            // Meesho
            'meeshoSales' => $meeshoSales,
            'meeshoOrderCount' => $meeshoOrderCount,
            'meeshoProducts' => $meeshoProductCount,
            'meeshoSellers' => $meeshoSellerCount,
            'meeshoReturns' => $meeshoReturns,
            'meeshoReturnCount' => $meeshoReturnCount,
            'meeshoBaseSales' => $meeshoBaseSales,
            'meeshoBaseReturns' => $meeshoBaseReturns,
        ]);
    }
}
