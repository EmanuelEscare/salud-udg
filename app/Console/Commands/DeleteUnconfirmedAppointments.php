<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnconfirmedAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:clear-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear appointments that have been pending for more than 30 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appointments = Appointment::whereNotNull('token')
            ->where('created_at', '<=', Carbon::now()->subMinutes(30))
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->delete();
        }

        $this->info('Expired appointments cleared successfully.');
        return Command::SUCCESS;
    }
}
