<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Amenity;

// Check if Stone Table Set already exists
$existingAmenity = Amenity::where('name', 'Stone Table Set')->first();

if (!$existingAmenity) {
    $amenity = Amenity::create([
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
    ]);
    
    echo "Stone Table Set amenity created successfully!\n";
    echo "ID: " . $amenity->id . "\n";
    echo "Name: " . $amenity->name . "\n";
    echo "Price: RM " . $amenity->price_per_booking . "\n";
    echo "Image: " . $amenity->image . "\n";
    echo "Active: " . ($amenity->is_active ? 'Yes' : 'No') . "\n";
} else {
    echo "Stone Table Set amenity already exists!\n";
    echo "ID: " . $existingAmenity->id . "\n";
    echo "Name: " . $existingAmenity->name . "\n";
    echo "Price: RM " . $existingAmenity->price_per_booking . "\n";
    echo "Image: " . $existingAmenity->image . "\n";
    echo "Active: " . ($existingAmenity->is_active ? 'Yes' : 'No') . "\n";
    
    // Update the image path if it's incorrect
    if ($existingAmenity->image !== 'images/amenities/anjung.jpg') {
        $existingAmenity->update(['image' => 'images/amenities/anjung.jpg']);
        echo "Image path updated to: images/amenities/anjung.jpg\n";
    }
}

// List all amenities
echo "\nAll amenities in database:\n";
$amenities = Amenity::all();
foreach ($amenities as $amenity) {
    echo "- " . $amenity->name . " (ID: " . $amenity->id . ", Image: " . $amenity->image . ", Active: " . ($amenity->is_active ? 'Yes' : 'No') . ")\n";
}
