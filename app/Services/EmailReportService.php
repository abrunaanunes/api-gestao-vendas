<?php

namespace App\Services;

use App\Jobs\SendSellerSummaryEmailJob;
use App\Jobs\SendManagerSummaryEmailJob;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmailReportService
{
    public function sendSellerSummaryEmails()
    {
        Seller::cursor()->each(function($seller) {
            $totalSalesValue = $seller->calculateTotalSalesValue();
            $totalCommission = $seller->calculateCommission();
            $totalSales = $seller->calculateDailyTotalSales();

            SendSellerSummaryEmailJob::dispatch($totalSales, $totalSalesValue, $totalCommission, $seller->email);
        });
    }

    public function sendManagersSummaryEmail()
    {
        User::cursor()->each(function($user) {
            $totalSalesValue = Sale::calculateTotalSalesValue();
            $totalCommission = Sale::calculateCommission();
            $totalSales = Sale::calculateDailyTotalSales();

            SendSellerSummaryEmailJob::dispatch($totalSales, $totalSalesValue, $totalCommission, $user->email);
        });
    }
}
