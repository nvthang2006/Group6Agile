<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Departure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'departure_date',
        'departure_time',
        'capacity',
        'booked_seats',
        'price',
        'status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'price'          => 'float',
        'capacity'       => 'integer',
        'booked_seats'   => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSeatsAttribute(): int
    {
        return max(0, (int) $this->capacity - (int) $this->booked_seats);
    }

    public function getDepartureAtAttribute(): Carbon
    {
        $time = $this->departure_time ?: '08:00:00';

        return Carbon::parse($this->departure_date->toDateString() . ' ' . $time);
    }

    public static function bookingCutoffHours(): int
    {
        return (int) config('booking.departure_cutoff_hours', 24);
    }

    public function isBookable(?int $cutoffHours = null): bool
    {
        $hours = $cutoffHours ?? self::bookingCutoffHours();
        return $this->status === 'open' && $this->departure_at->gt(now()->addHours($hours));
    }
}
