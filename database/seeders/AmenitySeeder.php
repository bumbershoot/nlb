<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'name' => 'Stone Table Set',
                'slug' => 'stone-table-set',
                'description' => 'Perfect for outdoor dining and BBQ experiences with durable stone table and seating for up to 5 people.',
                'price_per_booking' => 54.00,
                'max_pax' => 5,
                'operating_hours_start' => '09:00:00',
                'operating_hours_end' => '17:00:00',
                'features' => ['bbq_bin', 'power_outlet', 'seating', 'outdoor_dining'],
                'image' => 'images/amenities/anjung.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}