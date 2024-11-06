<?php

namespace App\Console;

use App\Services\EmailReportService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $salesEmailService = new EmailReportService();

        $schedule->call(function () use ($salesEmailService) {
            try {
                $salesEmailService->sendSellerSummaryEmails();
                Log::info('Seller summary emails sent successfully.');
            } catch (\Exception $e) {
                Log::error('Error sending seller summary emails: ' . $e->getMessage());
            }
        })->dailyAt('22:00');

        $schedule->call(function () use ($salesEmailService) {
            try {
                $salesEmailService->sendManagersSummaryEmail();
                Log::info('Manager summary emails sent successfully.');
            } catch (\Exception $e) {
                Log::error('Error sending manager summary emails: ' . $e->getMessage());
            }
        })->dailyAt('22:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
