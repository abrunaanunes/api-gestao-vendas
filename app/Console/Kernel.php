<?php

namespace App\Console;

use App\Services\EmailReportService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $salesEmailService = new EmailReportService();

        $schedule->call(function () use ($salesEmailService) {
            $salesEmailService->sendSellerSummaryEmails();
        })->dailyAt('20:00');

        $schedule->call(function () use ($salesEmailService) {
            $salesEmailService->sendManagersSummaryEmail();
        })->dailyAt('20:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
