<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    /**
     * Allow mass assignment for these fields.
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'total_price',
    ];

    /**
     * Cast dates automatically to Carbon instances.
     */
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /**
     * Relationship: A booking belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A booking belongs to a room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Check if this booking is still active (today is before or equal to check_out).
     */
    public function getIsActiveAttribute()
    {
        return $this->check_out->gte(Carbon::today());
    }

    /**
     * Scope: Only active bookings.
     */
    public function scopeActive($query)
    {
        return $query->whereDate('check_out', '>=', Carbon::today());
    }

    /**
     * Get the status of the booking.
     * Returns: 'Upcoming', 'Active', or 'Completed'
     */
    public function status()
    {
        $today = Carbon::today();

        if ($today->lt($this->check_in)) {
            return 'Upcoming';
        } elseif ($today->between($this->check_in, $this->check_out)) {
            return 'Active';
        } else {
            return 'Completed';
        }
    }
}
