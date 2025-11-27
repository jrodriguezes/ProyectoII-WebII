<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $table = 'users';

    // ajustes del primary key (char(9)
    protected $primaryKey = 'id';
    public $incrementing = false;      // autoincrement off
    protected $keyType = 'string'; // char 9 

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone_number',
        'profile_photo',
        'password',
        'user_type',
        'status',
        'email_verified_at',
        'verify_token_hash',
        'verify_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'verify_token_hash',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
        'verify_token_expires_at' => 'datetime',
    ];

    // un driver tiene muchos rides
    public function rides(): HasMany
    {
        return $this->hasMany(Ride::class, 'driver_id', 'id');
    }

    // un usuario (pasajero) tiene muchas reservas
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'passenger_id', 'id');
    }

    // vehiculos asociados (nota: driver_id es char(11) en vehicles) 
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'driver_id', 'id');
    }
}
