<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use App\Models\Products;

use Smalot\PdfParser\Parser;
use App\Models\OrderProduct;
use Str;


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
            ->sum(DB::raw('order_products.gst_price * order_products.quantity'));

        // ✅ Amazon Base Sales
        $amazonBaseSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $amazonOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('order_products.gst_price * order_products.quantity'));

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
            ->sum(DB::raw('order_products.gst_price * order_products.quantity'));

        // Meesho base sales based on base_price
        $meeshoBaseSales = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('order_products.gst_price * order_products.quantity'));

        $meeshoBaseProfit = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Delivered')
            ->sum(DB::raw('(order_products.price - order_products.gst_price) * order_products.quantity'));

        $meeshoBaseReturnsProfit = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Returned')
            ->sum(DB::raw('(order_products.price - order_products.gst_price) * order_products.quantity'));

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
            'meeshoBaseProfit' => $meeshoBaseProfit,
            'meeshoBaseReturnsProfit' => $meeshoBaseReturnsProfit,
        ]);
    }


    public function upload(Request $request)
    {
        $request->validate([
            'label_pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('label_pdf')->getPathname());
        $text = $pdf->getText();
        $lines = preg_split("/\r\n|\n|\r/", $text);

        $shippingPartners = ['Delhivery', 'Shadowfax', 'Ecom Express', 'XpressBees'];
        $shipping = 'Unknown';
        $purchaseDate = now()->format('Y-m-d');

        // Detect shipping partner
        foreach ($shippingPartners as $partner) {
            foreach ($lines as $line) {
                if (Str::contains(Str::lower($line), Str::lower($partner))) {
                    $shipping = $partner;
                    break 2;
                }
            }
        }

        // Detect purchase date
        foreach ($lines as $i => $line) {
            if (Str::contains($line, 'Order Date')) {
                $dateLine = trim($lines[$i + 1] ?? '');
                $purchaseDate = \Carbon\Carbon::createFromFormat('d.m.Y', $dateLine)->format('Y-m-d');
                break;
            }
        }

        // Extract product rows
        $products = [];
        foreach ($lines as $i => $line) {
            if (Str::contains($line, 'SKU	Size Qty Color Order No.')) {
                $dataLine = trim($lines[$i + 1] ?? '');
                // Split wherever an Order No. pattern appears
                preg_match_all(
                    '/([A-Z0-9\-]+(?:\s+[A-Z0-9]+)?)\s+([0-9A-Za-z\- ]{3,})\s+(\d+)\s+([A-Za-z]+|NA)\s+(\d{15,}_\d+)/',
                    $dataLine,
                    $matches,
                    PREG_SET_ORDER
                );

                foreach ($matches as $match) {
                    $products[] = [
                        'sku' => $match[1],
                        'size' => $match[2],
                        'quantity' => (int)$match[3],
                        'color' => $match[4],
                        'order_no' => $match[5],
                    ];
                }
            }
        }

        echo "<pre>";
        print_r($shipping);
        echo "</pre>";
        echo "<pre>";
        print_r($purchaseDate);
        echo "</pre>";
        echo "<pre>";
        print_r($products);
        echo "</pre>";
        die;

        // if (!$sku || !$orderNo) {
        //     return back()->with('error', 'Failed to extract required data from PDF.');
        // }

        // echo "<pre>"; print_r($sku); echo "</pre>";die;
        // $product = Product::where('platform_sku', $sku)->first();

        // if (!$product) {
        //     return back()->with('error', "SKU $sku not found in product database.");
        // }

        // // Create the order
        // $order = Order::create([
        //     'order_number' => 'ORD-' . strtoupper(Str::random(8)),
        //     'sold_on' => 'Meesho',
        //     'sub_order_id' => $orderNo,
        //     'shipping' => $shipping ?? 'Unknown',
        //     'purchase_date' => $purchaseDate,
        //     'total_amount' => $product->price * $quantity,
        // ]);

        // // Attach product to order
        // $order->product()->attach($product->id, [
        //     'price' => $product->price,
        //     'base_price' => $product->cost_price,
        //     'gst_price' => round($product->cost_price * 1.05, 2),
        //     'quantity' => $quantity,
        //     'subtotal' => $product->price * $quantity,
        // ]);

        return back()->with('success', 'Order placed successfully for SKU: ' . $sku);
    }
}