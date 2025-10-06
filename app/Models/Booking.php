<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cabana_id',
        'amenity_id',
        'booking_type',
        'name',
        'phone',
        'email',
        'date_from',
        'date_to',
        'check_in_time',
        'check_out_time',
        'pax',
        'total_price',
        'status',
        'google_calendar_event_id',
        'calendar_synced_at',
        'calendar_sync_enabled',
    ];

    public function cabana()
    {
        return $this->belongsTo(Cabana::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Check if booking is synced with Google Calendar
     */
    public function isCalendarSynced()
    {
        return !is_null($this->google_calendar_event_id);
    }

    /**
     * Check if booking should be synced with Google Calendar
     */
    public function shouldSyncToCalendar()
    {
        return $this->calendar_sync_enabled && $this->status === 'confirmed';
    }

    /**
     * Scope for confirmed bookings that should be synced
     */
    public function scopeSyncable($query)
    {
        return $query->where('calendar_sync_enabled', true)
                    ->where('status', 'confirmed');
    }
}
