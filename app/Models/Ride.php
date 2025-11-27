<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ride extends Model
{
    protected $table = 'rides';

    public $timestamps = true;

    protected $fillable = [
        'driver_id',
        'vehicle_plate',
        'name',
        'origin',
        'destination',
        'departure_date',
        'price_per_seat',
        'seats_offered',
        'status',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'price_per_seat' => 'decimal:2',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_plate', 'plate_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'ride_id', 'id');
    }
}
