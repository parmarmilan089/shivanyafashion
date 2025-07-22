<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceOrder extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'billing_name',
        'billing_phone',
        'billing_email',
        'billing_address',
        'status',
        'total_amount',
        'payment_method',
        'payment_status',
        'platform',
    ];

    // Relationship: Order has many items
    public function items()
    {
        return $this->hasMany(MarketplaceOrderItem::class);
    }

    // Optional: link to customer if using customers table
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
