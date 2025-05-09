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
        'order_status',
        'total_amount',
        'purchase_date',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('price', 'quantity', 'subtotal')
            ->withTimestamps();
    }
}
