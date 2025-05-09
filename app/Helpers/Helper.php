<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Order;

class Helper
{
    // Function to get the total sales (sum of all order amounts)
    public static function getMeeshoTotalSales()
    {
        return Order::where('sold_on', 'Meesho')->sum('total_amount');
    }

    public static function getMeeshoTodayOrderCount()
    {
        return Order::whereDate('purchase_date', Carbon::today())
            ->where('sold_on', 'Meesho')
            ->count();
    }

    public static function getMeeshoTodayOrderAmount()
    {
        return Order::where('sold_on', 'Meesho')
            ->whereDate('purchase_date', Carbon::today())
            ->sum('total_amount');
    }
}
