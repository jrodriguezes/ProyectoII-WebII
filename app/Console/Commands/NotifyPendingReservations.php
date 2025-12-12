<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendingReservationMail;

class NotifyPendingReservations extends Command
{
    protected $signature = 'reservations:notify {minutes=15}';
    protected $description = 'Notify drivers of pending reservations';

    public function handle()
    {
        $minutes = (int) $this->argument('minutes');

        $reservations = Reservation::where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes($minutes))
            ->with(['ride.driver', 'passenger'])
            ->get();

        if ($reservations->isEmpty()) {
            $this->info('No hay resultados');
            return Command::SUCCESS;
        }

        foreach ($reservations as $reservation) {

            if (!$reservation->ride || !$reservation->ride->driver) {
                continue;
            }

            $driver = $reservation->ride->driver;
            $passenger = $reservation->passenger;

            $minutesPassed = $reservation->created_at->diffInMinutes(now());

            $this->info(
                "Driver: {$driver->first_name} | Ride: {$reservation->ride->name} | Min: {$minutesPassed}"
            );

            Mail::to($driver->email)->send(
                new PendingReservationMail(
                    $reservation,
                    $driver,
                    $passenger
                )
            );
        }

        return Command::SUCCESS;
    }
}
