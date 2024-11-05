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

    public $totalSalesValue;

    public function __construct($totalSalesValue)
    {
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
                'totalSalesValue' => $this->totalSalesValue,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
