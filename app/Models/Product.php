<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'seller_name',
        'platform_sku',
        'price',
        'base_price',
        'gst_price',
        'status',
        'image',
        'selling_platform',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot('price', 'quantity', 'subtotal')
            ->withTimestamps();
    }
}
