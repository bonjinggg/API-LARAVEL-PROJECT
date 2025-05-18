<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';

    protected $fillable = ['name'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_service', 'service_id', 'booking_id');
    }
}
