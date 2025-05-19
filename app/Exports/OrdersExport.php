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

    public function __construct($fromDate = null, $toDate = null)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        $query = Order::with('product')
        ->where('sold_on', 'Meesho');

        if ($this->fromDate) {
            $query->whereDate('purchase_date', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('purchase_date', '<=', $this->toDate);
        }

        $orders = $query->get();
        $this->rowCount = $orders->count(); // Save for totals row

        return $orders;
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
            'Profit',
        ];
    }

    public function map($order): array
    {
        $product = $order->product->first();
        $basePrice = $product ? $product->base_price : 0;
        $totalAmount = $order->total_amount ?? 0;

        $profit = $totalAmount - $basePrice;

        return [
            $order->order_number,
            $order->sold_on,
            $order->sub_order_id ?? '',
            $order->shipping ?? '',
            $order->purchase_date ? $order->purchase_date->format('Y-m-d') : '',
            $totalAmount,
            $basePrice,
            $product ? $product->name : '',
            $product ? $product->platform_sku : '',
            $order->order_status ?? '',
            $product ? $product->pivot->quantity : '',
            $profit,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Make headers bold
                $sheet->getStyle('A1:L1')->getFont()->setBold(true);

                // Total row comes after all data
                $totalRow = $this->rowCount + 2;

                // Label
                $sheet->setCellValue("K{$totalRow}", 'TOTAL:');

                // Excel formulas
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F" . ($totalRow - 1) . ")");
                $sheet->setCellValue("L{$totalRow}", "=SUM(L2:L" . ($totalRow - 1) . ")");

                // Bold total row
                $sheet->getStyle("A{$totalRow}:L{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
