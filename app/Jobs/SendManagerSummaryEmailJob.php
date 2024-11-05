<?php

namespace App\Jobs;

use App\Mail\ManagerSummaryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendManagerSummaryEmailJob
{
    use Queueable, SerializesModels;

    public $totalSales;
    public $totalValue;
    public $managerEmail;

    public function __construct($totalSales, $totalValue, $managerEmail)
    {
        $this->totalSales = $totalSales;
        $this->totalValue = $totalValue;
        $this->managerEmail = $managerEmail;
    }

    public function handle()
    {
        Mail::to($this->managerEmail)->send(new ManagerSummaryMail($this->totalSales, $this->totalValue));
    }
}
