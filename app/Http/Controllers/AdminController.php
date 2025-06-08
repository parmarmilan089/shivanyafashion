<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
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
            ->sum(DB::raw('order_products.base_price * order_products.quantity'));
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
            ->whereIn('order_status', ['Returned', 'RTO-Return', 'Wrong-RTO-Return', 'Wrong-Return', 'Missing-Return']) // again, adjust if needed
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

        $meeshoShippingCharges = DB::table('orders')
            ->whereIn('order_status', ['Returned', 'Missing-Return', 'Wrong-Return'])
            ->sum('return_charges');
        $meeshoBaseReturnsProfit = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->whereIn('order_products.order_id', $meeshoOrderIds)
            ->where('orders.order_status', 'Returned')
            ->sum(DB::raw('(order_products.price - order_products.gst_price) * order_products.quantity'));

        $totalPayment = DB::table('payments')->sum('amount');

        $topSellingProducts = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->where('orders.sold_on', 'Meesho')
            // ->where('orders.payment_status', 1)
            ->groupBy('order_products.product_id', 'products.name', 'products.image', 'products.platform_sku')
            ->select(
                'products.name',
                'products.platform_sku',
                'products.image',
                DB::raw('COUNT(order_products.id) as total_orders')
            )
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        $badProducts = DB::table('order_products')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->where('orders.sold_on', 'Meesho')
            ->whereIn('orders.order_status', ['Returned', 'RTO-Return', 'Wrong-RTO-Return', 'Wrong-Return', 'Missing-Return'])
            ->groupBy('order_products.product_id', 'products.name', 'products.image', 'products.platform_sku')
            ->select(
                'products.name',
                'products.platform_sku',
                'products.image',
                DB::raw('COUNT(order_products.id) as bad_orders')
            )
            ->orderByDesc('bad_orders')
            ->limit(10)
            ->get();

        // Example 1: Monthly Sales (last 12 months)
        $sales = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $salesLabels = [];
        $salesData = [];

        for ($i = 1; $i <= 12; $i++) {
            $salesLabels[] = $months[$i - 1];
            $salesData[] = $sales[$i] ?? 0;
        }

        // Example 2: Daily Website Views (Dummy/static example; replace with real analytics if available)
        $viewsLabels = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $viewsData = [120, 150, 130, 170, 140, 200, 220]; // Replace with actual DB data if needed

        // Example 3: Monthly Tasks Completed (Dummy)
        $tasksLabels = ["Apr", "May", "Jun", "Jul", "Aug"];
        $tasksData = [15, 22, 18, 30, 25]; // Replace with actual DB queries if needed


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
            'meeshoShippingCharges' => $meeshoShippingCharges,

            'totalPayment' => $totalPayment,
            'topSellingProducts' => $topSellingProducts,
            'badProducts' => $badProducts,

            'salesLabels' => json_encode($salesLabels),
            'salesData' => json_encode($salesData),
            'viewsLabels' => json_encode($viewsLabels),
            'viewsData' => json_encode($viewsData),
            'tasksLabels' => json_encode($tasksLabels),
            'tasksData' => json_encode($tasksData),
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'label_pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('label_pdf')->getPathname());
        $lines = preg_split("/\r\n|\n|\r/", $pdf->getText());
        // echo '<pre>';print_r($lines); echo '</pre>';die;
        $orders = [];
        $notinproduct = [];

        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);

            // ✅ Detect 'Pickup' even if merged (e.g., "PickupSKU Size Qty...")
            if (Str::contains(Str::lower($line), 'pickup')) {
                // Capture the previous line as the shipping partner
                $shippingLine = trim($lines[$i - 1] ?? '');
                $orders[] = array(
                    'purchase_date' => null,
                    'shipping' => $shippingLine,
                    'products' => [],
                );
            }

            if (Str::contains($line, 'SKU') && Str::contains($line, 'Order No')) {
                $dataLines = '';
                for ($j = $i + 1; $j < count($lines); $j++) {
                    $nextLine = trim($lines[$j]);

                    // Stop if we hit the end of product section
                    if (
                        Str::contains($nextLine, 'TAX INVOICE') ||
                        Str::contains($nextLine, 'BILL TO') ||
                        Str::contains($nextLine, 'Customer Address') ||
                        Str::contains($nextLine, 'Order Date')
                    ) {
                        break;
                    }

                    $dataLines .= ' ' . $nextLine;
                }
                // ✅ Extract product details
                preg_match_all(
                    '/([A-Za-z0-9\-\s]+?)\s+([0-9A-Za-z\- ]+?)\s+(\d+)\s+([A-Za-z ]+?)\s+(\d{15,}_\d+)/',
                    $dataLines,
                    $matches,
                    PREG_SET_ORDER
                );

                $products = [];
                foreach ($matches as $match) {
                    $sku = str_replace(' ', '', trim($match[1]));
                    $products[] = [
                        'sku' => str_replace(' ', '', trim($sku)),
                        'size' => trim($match[2]),
                        'quantity' => (int) $match[3],
                        'color' => trim($match[4]),
                        'order_no' => trim($match[5]),
                    ];

                    // ✅ Check if this SKU exists in the products table
                    $productExists = Product::where('platform_sku', $sku)->exists();

                    if (!$productExists) {
                        $notinproduct[] = $sku;
                    }
                }

                $orders[count($orders) - 1]['products'] = $products;
            }

            // if (Str::contains($line, 'Order Date')) {
            //     try {
            //         $purchaseDate = Carbon::createFromFormat('d.m.Y', $lines[$i + 1])->format('Y-m-d');
            //     } catch (\Exception $e) {
            //         $purchaseDate = null;
            //     }
            //     $orders[count($orders) - 1]['purchase_date'] = $purchaseDate;
            // }
        }
        // echo "<pre>"; print_r($notinproduct); echo "</pre>";
        // echo "<pre>";
        // print_r($orders);
        // echo "</pre>";
        // die;

        if (count($orders) > 0 && count($notinproduct) == 0) {
            foreach ($orders as $key => $products) {
                foreach ($products['products'] as $product) {
                    $productdetails = Product::where('platform_sku', $product['sku'])->first();
                    if ($productdetails) {
                        // Create the order
                        $orderdata = [
                            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                            'sold_on' => 'Meesho',
                            'sub_order_id' => $product['order_no'],
                            'shipping' => $products['shipping'],
                            'purchase_date' => $products['purchase_date'] ?? Carbon::today()->toDateString(),
                            'total_amount' => ($productdetails['price'] * $product['quantity']),
                        ];
                        // echo "<pre>"; print_r($orderdata); echo "</pre>";
                        $order = Order::create($orderdata);
                        $orderproductdata = [
                            'price' => $productdetails['price'],
                            'base_price' => $productdetails['base_price'],
                            'gst_price' => round($productdetails['base_price'] * 1.05, 2),
                            'size' => $product['size'],
                            'quantity' => $product['quantity'],
                            'subtotal' => $productdetails['price'] * $product['quantity'],
                        ];
                        // echo "<pre>"; print_r($orderproductdata); echo "</pre>";
                        // echo "<pre>"; print_r('============================================'); echo "</pre>";
                        // Attach product to order
                        $order->product()->attach($productdetails['id'], $orderproductdata);
                    } else {
                        $notinproduct[] = $product['sku'];
                    }
                }
            }
            return back()->with('success', 'Order(s) placed successfully!');
        } else {
            return back()->with([
                'error' => 'Some products were not found.',
                'missing_skus' => $notinproduct,
            ]);
        }
    }

    // public function uploadd(Request $request)
    // {
    //     $request->validate([
    //         'label_pdf' => 'required|mimes:pdf|max:5120',
    //     ]);

    //     $parser = new Parser();
    //     $pdf = $parser->parseFile($request->file('label_pdf')->getPathname());
    //     $lines = preg_split("/\r\n|\n|\r/", $pdf->getText());

    //     $labels = [];

    //     for ($i = 0; $i < count($lines); $i++) {
    //         $line = trim($lines[$i]);

    //         // 🔁 Detect start of a new label block
    //         if (Str::contains($line, 'SKU') && Str::contains($line, 'Order No')) {
    //             $labelLines = [];
    //             $shipping = 'Unknown';
    //             $purchaseDate = null;

    //             // 📦 Collect lines in this label
    //             for ($j = $i + 1; $j < count($lines); $j++) {
    //                 $nextLine = trim($lines[$j]);

    //                 // End of label block (start of next label)
    //                 if (Str::contains($nextLine, 'SKU') && Str::contains($nextLine, 'Order No')) {
    //                     $i = $j - 1;
    //                     break;
    //                 }

    //                 $labelLines[] = $nextLine;
    //             }

    //             // ✅ Detect shipping only from this label's lines
    //             for ($k = 1; $k < count($labelLines); $k++) {
    //                 if (Str::contains(Str::lower($labelLines[$k]), 'pickup')) {
    //                     $shipping = trim($labelLines[$k - 1]);
    //                     break;
    //                 }
    //             }

    //             // 📅 Detect purchase date
    //             $joined = implode(' ', $labelLines);
    //             $joined = preg_replace('/\s+/', ' ', $joined);

    //             if (preg_match('/Order Date\s+(\d{2}\.\d{2}\.\d{4})/', $joined, $dateMatch)) {
    //                 try {
    //                     $purchaseDate = Carbon::createFromFormat('d.m.Y', $dateMatch[1])->format('Y-m-d');
    //                 } catch (\Exception $e) {
    //                     $purchaseDate = null;
    //                 }
    //             }

    //             // 🧾 Extract products
    //             preg_match_all(
    //                 '/([A-Z0-9\-\s]+)\s+([0-9A-Za-z\- ]+)\s+(\d+)\s+([A-Za-z ]+)\s+(\d{15,}_\d+)/',
    //                 $joined,
    //                 $matches,
    //                 PREG_SET_ORDER
    //             );

    //             $products = [];

    //             foreach ($matches as $match) {
    //                 $products[] = [
    //                     'sku' => str_replace(' ', '', trim($match[1])),
    //                     'size' => trim($match[2]),
    //                     'quantity' => (int) $match[3],
    //                     'color' => trim($match[4]),
    //                     'order_no' => trim($match[5]),
    //                 ];
    //             }

    //             // ✅ Store label if products found
    //             if (count($products)) {
    //                 $labels[] = [
    //                     'shipping' => $shipping,
    //                     'purchase_date' => $purchaseDate,
    //                     'products' => $products,
    //                 ];
    //             }
    //         }
    //     }

    //     echo "<pre>";
    //     print_r($labels);
    //     echo "</pre>";
    //     die;
    //     // if (!$sku || !$orderNo) {
    //     //     return back()->with('error', 'Failed to extract required data from PDF.');
    //     // }

    //     // echo "<pre>"; print_r($sku); echo "</pre>";die;
    //     // $product = Product::where('platform_sku', $sku)->first();

    //     // if (!$product) {
    //     //     return back()->with('error', "SKU $sku not found in product database.");
    //     // }

    //     // // Create the order
    //     // $order = Order::create([
    //     //     'order_number' => 'ORD-' . strtoupper(Str::random(8)),
    //     //     'sold_on' => 'Meesho',
    //     //     'sub_order_id' => $orderNo,
    //     //     'shipping' => $shipping ?? 'Unknown',
    //     //     'purchase_date'` => $purchaseDate,
    //     //     'total_amount' => $product->price * $quantity,
    //     // ]);

    //     // // Attach product to order
    //     // $order->product()->attach($product->id, [
    //     //     'price' => $product->price,
    //     //     'base_price' => $product->cost_price,
    //     //     'gst_price' => round($product->cost_price * 1.05, 2),
    //     //     'quantity' => $quantity,
    //     //     'subtotal' => $product->price * $quantity,
    //     // ]);

    //     return back()->with('success', 'Order placed successfully for SKU: ' . $sku);
    // }

    // public function upload2(Request $request)
    // {
    //     $request->validate([
    //         'label_pdf' => 'required|mimes:pdf|max:5120',
    //     ]);

    //     $parser = new Parser();
    //     $pdf = $parser->parseFile($request->file('label_pdf')->getPathname());
    //     $lines = preg_split("/\r\n|\n|\r/", $pdf->getText());
    //     // echo '<pre>';print_r($lines); echo '</pre>';die;

    //     $labels = [];
    //     $shippings = $labelLines = [];
    //     $shipping = 'Unknown';

    //     $collecting = false;

    //     for ($i = 1; $i < count($lines); $i++) {
    //         $line = trim($lines[$i]);

    //         // ✅ Detect 'Pickup' even if merged (e.g., "PickupSKU Size Qty...")
    //         if (Str::contains(Str::lower($line), 'pickup')) {
    //             // echo '<pre>2222';print_r($line); echo '</pre>';
    //             // Capture the previous line as the shipping partner
    //             $shippingLine = trim($lines[$i - 1] ?? '');
    //             $shipping = $shippingLine;
    //             // echo '<pre>000';print_r($shipping); echo '</pre>';
    //             $shippings = array(
    //                 'purchase_date' => null,
    //                 'shipping' => $shipping,
    //                 'products' => [],
    //             );

    //             // echo "<pre>3243"; print_r($labelLines); echo "</pre>";
    //             // echo '<pre>';print_r($shippings); echo '</pre>';
    //             if (!empty($labelLines)) {
    //                 // echo "<pre>andar "; print_r($shipping); echo "</pre>";
    //                 $labels[] = $this->parseLabelBlock($labelLines, $shipping);
    //                 $labelLines = [];
    //             }

    //             // Split current line in case it's merged: "PickupSKU Size Qty Color Order No."
    //             $pickupParts = preg_split('/pickup/i', $line);
    //             if (isset($pickupParts[1]) && trim($pickupParts[1]) !== '') {
    //                 $labelLines[] = 'SKU ' . trim($pickupParts[1]);
    //             }

    //             $collecting = true;
    //             continue; // Skip re-adding this line
    //         }

    //         if ($collecting) {
    //             $labelLines[] = $line;
    //         }
    //     }

    //     // ✅ Final label block
    //     if (!empty($labelLines)) {
    //         $labels[] = $this->parseLabelBlock($labelLines, $shipping);
    //     }

    //     // ✅ Output the result
    //     echo "<pre>";
    //     print_r($labels);
    //     echo "</pre>";
    //     die;
    // }

    // private function parseLabelBlock(array $labelLines, string $shipping)
    // {
    //     $purchaseDate = null;

    //     // Join and normalize label lines
    //     $joined = implode(' ', $labelLines);
    //     $joined = preg_replace('/\s+/', ' ', $joined);

    //     // ✅ Extract purchase/order date
    //     if (preg_match('/Order Date\s+(\d{2}\.\d{2}\.\d{4})/', $joined, $dateMatch)) {
    //         try {
    //             $purchaseDate = Carbon::createFromFormat('d.m.Y', $dateMatch[1])->format('Y-m-d');
    //         } catch (\Exception $e) {
    //             $purchaseDate = null;
    //         }
    //     }

    //     // ✅ Extract product details
    //     preg_match_all(
    //         '/([A-Z0-9\-\s]+)\s+([0-9A-Za-z\- ]+)\s+(\d+)\s+([A-Za-z ]+)\s+(\d{15,}_\d+)/',
    //         $joined,
    //         $matches,
    //         PREG_SET_ORDER
    //     );

    //     $products = [];

    //     foreach ($matches as $match) {
    //         $products[] = [
    //             'sku' => str_replace(' ', '', trim($match[1])),
    //             'size' => trim($match[2]),
    //             'quantity' => (int) $match[3],
    //             'color' => trim($match[4]),
    //             'order_no' => trim($match[5]),
    //         ];
    //     }

    //     return [
    //         'shipping' => $shipping,
    //         'purchase_date' => $purchaseDate,
    //         'products' => $products,
    //     ];
    // }
}
