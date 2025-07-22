<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceOrderItem extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'marketplace_order_id',
        'product_id',
        'variant_id',
        'product_name',
        // 'sku',
        'price',
        'qty',
        'subtotal',
    ];

    // Relationship: Item belongs to an order
    public function order()
    {
        return $this->belongsTo(MarketplaceOrder::class, 'marketplace_order_id');
    }


    // Optional: relation to variant if you have one
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function inventory()
    {
        // Directly relate product_id to inventory_id
        return $this->belongsTo(\App\Models\Inventory::class, 'product_id');
    }
}
