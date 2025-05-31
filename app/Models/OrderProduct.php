<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'price',
        'base_price',
        'gst_price',
        'quantity',
        'size',
        'subtotal',
        'expected_amount',
        'received_amount',
        'payment_status',
        'payment_note',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
