<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $fromDate;
    protected $toDate;
    protected $rowCount = 0; // Track for totals

    public function __construct($start_date = null, $end_date = null)
    {
        $this->fromDate = $start_date;
        $this->toDate = $end_date;
    }

    public function collection()
    {
        $query = Order::with(['orderProducts.product']) // load orderProducts + their product
            ->where('sold_on', 'Meesho');
            // ->where('payment_status', 0);

        if ($this->fromDate) {
            $query->whereDate('purchase_date', '>=', date('Y-m-d', strtotime($this->fromDate)));
        }

        if ($this->toDate) {
            $query->whereDate('purchase_date', '<=', date('Y-m-d', strtotime($this->toDate)));
        }

        $orders = $query->get();

        // Flatten to one row per order product
        $flattened = collect();

        foreach ($orders as $order) {
            foreach ($order->orderProducts as $orderProduct) {
                $flattened->push([
                    'order' => $order,
                    'orderProduct' => $orderProduct,
                    'product' => $orderProduct->product,
                ]);
            }
        }

        $this->rowCount = $flattened->count();

        return $flattened;
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Sold On',
            'Sub Order ID',
            'Shipping',
            'Purchase Date',
            'Total Amount',
            'Base Price',
            'Product Name',
            'Platform SKU',
            'Order Status',
            'Quantity',
            'Shippng Charges',
            'Payment Status',
            'Profit',
        ];
    }

    public function map($row): array
    {
        $order = $row['order'];
        $orderProduct = $row['orderProduct'];
        $product = $row['product'];

        $totalAmount = $order->total_amount ?? 0;
        $getPrice = $orderProduct->gst_price ?? 0;
        $quantity = $orderProduct->quantity ?? 1;

        $profit = 0;
        if($order->payment_status == 1){
            $profit = ($orderProduct->price - $orderProduct->gst_price) * $quantity;
        } else {
            $profit = 0;
        }

        $payment_status = match ($order->payment_status) {
            1 => 'Received',
            2 => 'Cancel',
            default => 'Pending',
        };

        return [
            $order->order_number,
            $order->sold_on,
            $order->sub_order_id ?? '',
            $order->shipping ?? '',
            $order->purchase_date ? $order->purchase_date->format('Y-m-d') : '',
            $totalAmount,
            $orderProduct->gst_price ?? 0,
            $product->name ?? '',
            $product->platform_sku ?? '',
            $order->order_status ?? '',
            $quantity,
            $order->return_charges,
            $payment_status,
            $profit,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Make headers bold
                $sheet->getStyle('A1:N1')->getFont()->setBold(true);

                // Total row comes after all data
                $totalRow = $this->rowCount + 2;

                // Label
                $sheet->setCellValue("K{$totalRow}", 'TOTAL:');

                // Excel formulas
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F" . ($totalRow - 1) . ")");
                $sheet->setCellValue("N{$totalRow}", "=SUM(N2:N" . ($totalRow - 1) . ")");
                $sheet->setCellValue("L{$totalRow}", "=SUM(L2:L" . ($totalRow - 1) . ")");

                // Bold total row
                $sheet->getStyle("A{$totalRow}:L{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
