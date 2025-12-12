<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reservation $reservation,
        public User $driver,
        public User $passenger
    ) {}

    public function build()
    {
        return $this
            ->subject('Reserva pendiente')
            ->view('emails.pending-reservation');
    }
}
