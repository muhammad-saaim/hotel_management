<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    /**
     * Allow mass assignment for these fields.
     */
    protected $fillable = [
        'name',
        'type',
        'price',
        'capacity',
        // We’ll keep 'is_available' for backward compatibility,
        // but availability is now handled dynamically
        'is_available',
        'image',
        
    ];

    /**
     * Relationship: A room can have many bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the room is available for specific dates.
     * Prevent overlapping bookings dynamically.
     */
    public function isAvailableForDates($checkIn, $checkOut)
    {
        $checkIn = Carbon::parse($checkIn);
        $checkOut = Carbon::parse($checkOut);

        return !$this->bookings()
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($query) use ($checkIn, $checkOut) {
                          $query->where('check_in', '<=', $checkIn)
                                ->where('check_out', '>=', $checkOut);
                      });
            })
            ->exists();
    }

    /**
     * Dynamic availability attribute (ignores is_available column).
     */
    public function getIsCurrentlyAvailableAttribute()
    {
        return !$this->bookings()
            ->whereDate('check_out', '>=', now())
            ->exists();
    }
}
