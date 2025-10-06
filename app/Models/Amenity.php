<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_per_booking',
        'max_pax',
        'operating_hours_start',
        'operating_hours_end',
        'features',
        'image',
        'is_active',
    ];

    // Cast JSON fields to array automatically
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
