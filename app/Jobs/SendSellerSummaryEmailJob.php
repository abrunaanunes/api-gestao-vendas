<?php

namespace App\Jobs;

use App\Mail\SellerSummaryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSellerSummaryEmailJob
{
    use Queueable, SerializesModels;

    public $totalSales;
    public $totalValue;
    public $totalCommission;
    public $sellerEmail;

    public function __construct($totalSales, $totalValue, $totalCommission, $sellerEmail)
    {
        $this->totalSales = $totalSales;
        $this->totalValue = $totalValue;
        $this->totalCommission = $totalCommission;
        $this->sellerEmail = $sellerEmail;
    }

    public function handle()
    {
        Mail::to($this->sellerEmail)->send(new SellerSummaryMail($this->totalSales, $this->totalValue, $this->totalCommission));
    }
}
