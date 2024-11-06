<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $totalSales;
    public $totalValue;
    public $totalCommission;

    public function __construct($totalSales, $totalValue, $totalCommission)
    {
        $this->totalSales = $totalSales;
        $this->totalValue = $totalValue;
        $this->totalCommission = $totalCommission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Sales Summary',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sales_summary',
            with: [
                'totalSales' => $this->totalSales,
                'totalValue' => $this->totalValue,
                'totalCommission' => $this->totalCommission,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
