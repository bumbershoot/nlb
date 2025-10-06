<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabana extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_daily',
        'price_overnight',
        'max_pax',
        'allow_overnight',
        'features',
        'image',
    ];

    // Cast JSON fields to array automatically
    protected $casts = [
        'features' => 'array',
        'allow_overnight' => 'boolean',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
