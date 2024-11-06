<?php

namespace App\Services;

use App\Jobs\SendSellerSummaryEmailJob;
use App\Jobs\SendManagerSummaryEmailJob;
use App\Mail\ManagerSummaryMail;
use App\Mail\SellerSummaryMail;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailReportService
{
    public function sendSellerSummaryEmails()
    {
        Seller::cursor()->each(function($seller) {
            $totalSales = $seller->calculateDailyTotalSales();
            $totalSalesValue = $seller->calculateDailyTotalSalesValue();
            $totalCommission = $seller->calculateDailyCommission();

            Mail::to($seller->email)->send(new SellerSummaryMail($totalSales, $totalSalesValue, $totalCommission));
            // SendSellerSummaryEmailJob::dispatch($totalSales, $totalSalesValue, $totalCommission, $seller->email);
        });
    }

    public function sendManagersSummaryEmail()
    {
        User::cursor()->each(function($user) {
            $totalSales = Sale::calculateDailyTotalSales();
            $totalSalesValue = Sale::calculateDailyTotalSalesValue();

            Mail::to($user->email)->send(new ManagerSummaryMail($totalSales, $totalSalesValue));
            // SendSellerSummaryEmailJob::dispatch($totalSales, $totalSalesValue, $totalCommission, $user->email);
        });
    }
}
