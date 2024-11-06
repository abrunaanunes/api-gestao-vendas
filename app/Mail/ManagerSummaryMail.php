<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $totalSales;
    public $totalSalesValue;

    public function __construct($totalSales, $totalSalesValue)
    {
        $this->totalSales = $totalSales;
        $this->totalSalesValue = $totalSalesValue;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Total Sales Summary for Today',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.manager_sales_summary',
            with: [
                'totalSales' => $this->totalSales,
                'totalSalesValue' => $this->totalSalesValue,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
