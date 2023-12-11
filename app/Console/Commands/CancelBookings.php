<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CancelBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel bookings that finished yesterday';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Booking::whereDate('finished_at', '=', now()->subDay())
            ->where('status', '<>', 'expired')
            ->update(['status' => 'expired']);

        $this->info('Bookings deleted successfully.');
    }
}
