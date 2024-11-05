<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function calculateDailyTotalSalesValue()
    {
        return $this->sales()->whereDate('sold_at', today())->sum('value');
    }

    public function calculateDailyCommission()
    {
        return $this->calculateTotalSalesValue() * 0.085;
    }

    public function calculateDailyTotalSales()
    {
        return $this->sales()->whereDate('sold_at', today())->count();
    }
}
