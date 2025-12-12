<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $table = 'reservations';

    public $timestamps = true;

    protected $fillable = [
        'ride_id',
        'passenger_id',
        'status',
    ];

    public function ride(): BelongsTo
    {
        return $this->belongsTo(Ride::class, 'ride_id', 'id');
    }

    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passenger_id', 'id');
    }

    public function scopePendingOlderThan(Builder $query, int $minutes)
    {
        return $query
            ->where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes($minutes))
            ->with([
                'ride.driver',     // chofer
                'passenger'        // pasajero
            ]);
    }
}
