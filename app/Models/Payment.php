<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_received_date',
        'amount',
        'return_sub_order_ids',
        'delivered_sub_order_ids',
        'description',
    ];

    protected $casts = [
        'sub_order_ids' => 'array',
    ];
}