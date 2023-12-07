<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CleanPendingBookings extends Command
{
    protected $signature = 'clean:pending-bookings';
    protected $description = 'Удаляет неподтвержденные брони, срок жизни которых больше 10 минут';

    public function handle()
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);

        Booking::where('status', 'pending')
            ->where('created_at', '<=', $tenMinutesAgo)
            ->delete();

        $this->info('Pending bookings older than 10 minutes have been cleaned.');
    }
}
