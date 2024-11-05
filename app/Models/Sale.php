<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'sold_at',
        'value',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public static function calculateDailyTotalSalesValue()
    {
        return Sale::whereDate('sold_at', today())->sum('value');
    }

    public static function calculateDailyCommission()
    {
        return self::calculateTotalSalesValue() * 0.085;
    }

    public static function calculateDailyTotalSales()
    {
        return Sale::whereDate('sold_at', today())->count();
    }
}
