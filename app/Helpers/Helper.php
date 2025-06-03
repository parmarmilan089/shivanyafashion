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
        $amount = Order::where('sold_on', 'Meesho')
        ->whereDate('purchase_date', Carbon::today())
        ->sum('total_amount');
        return self::formatIndianCurrency($amount);
    }

    public static function getAmazonTotalSales()
    {
        return Order::where('sold_on', 'Amazon')->sum('total_amount');
    }

    public static function getAmazonTodayOrderCount()
    {
        return Order::whereDate('purchase_date', Carbon::today())
            ->where('sold_on', 'Amazon')
            ->count();
    }

    public static function getAmazonTodayOrderAmount()
    {
        return Order::where('sold_on', 'Amazon')
            ->whereDate('purchase_date', Carbon::today())
            ->sum('total_amount');
    }

    public static function formatIndianCurrency($amount) {
        $amount = number_format($amount, 2, '.', '');
        $x = explode('.', $amount);
        $integerPart = $x[0];
        $decimalPart = $x[1];
    
        $lastThree = substr($integerPart, -3);
        $restUnits = substr($integerPart, 0, -3);
        if ($restUnits != '') {
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . "," . $lastThree;
        } else {
            $formatted = $lastThree;
        }
    
        return $formatted . "." . $decimalPart;
    }
}
