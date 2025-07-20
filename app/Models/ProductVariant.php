<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'color_id',
        'size_id',
        'price',
        'sale_price',
        'stock_qty',
        'sale_start',
        'sale_end',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
} 