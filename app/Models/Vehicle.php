<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'plate_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'plate_id',
        'driver_id',
        'color',
        'brand',
        'model',
        'year',
        'seats',
        'vehicle_picture',
        'status',
    ];

    public function driver(): BelongsTo
    {
        // Ojo: driver_id es char(11), users.id int(11)
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function rides(): HasMany
    {
        return $this->hasMany(Ride::class, 'vehicle_plate', 'plate_id');
    }
}
