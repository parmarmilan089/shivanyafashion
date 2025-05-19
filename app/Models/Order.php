<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'sold_on',
        'sub_order_id',
        'shipping',
        'order_status',
        'total_amount',
        'purchase_date',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',  // or 'datetime' if time included
    ];

    protected $dates = ['purchase_date'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('price', 'quantity', 'base_price', 'subtotal')
            ->withTimestamps();
    }
}
