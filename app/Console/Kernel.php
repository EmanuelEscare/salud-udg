<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('appointments:clear-expired')->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Cron job php artisan schedule:run
        $this->load(__DIR__.'/Commands');

        $this->commands([
            \App\Console\Commands\DeleteUnconfirmedAppointments::class,
        ]);

        require base_path('routes/console.php');
    }
}
