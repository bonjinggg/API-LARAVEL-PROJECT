<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'full_name',
        'email',
        'booking_reference',
        'status',
        'from_date',
        'to_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = strtoupper(Str::random(10));
        });
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service', 'booking_id', 'service_id');
    }
}
