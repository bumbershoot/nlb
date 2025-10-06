<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cabana;
use Illuminate\Database\Seeder;

class CabanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabanas = [
            // Ordered as requested by user
            ['name' => 'Cabana Iris', 'slug' => 'cabana-iris', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Tulip', 'slug' => 'cabana-tulip', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/cabana-tulip.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Rafflesia', 'slug' => 'cabana-rafflesia', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/rafflesia-lavender.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Lavender', 'slug' => 'cabana-lavender', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/rafflesia-lavender.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Royal Cabana', 'slug' => 'royal-cabana', 'price_daily' => 270, 'max_pax' => 6, 'image' => 'images/cabanas/royal-cabana.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Premium Royal Cabana experience with luxury amenities. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
            ['name' => 'Cabana Camellia', 'slug' => 'cabana-camellia', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Jasmine', 'slug' => 'cabana-jasmine', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Freesia', 'slug' => 'cabana-freesia', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Sakura', 'slug' => 'cabana-sakura', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Hibiscus', 'slug' => 'cabana-hibiscus', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Orked', 'slug' => 'cabana-orked', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Rozella', 'slug' => 'cabana-rozella', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful riverside cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Rossa', 'slug' => 'cabana-rossa', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Premium cabana with maximum 6 PAX only. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
            ['name' => 'Cabana Aster', 'slug' => 'cabana-aster', 'price_daily' => 216, 'max_pax' => 12, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Large capacity cabana for bigger groups with maximum 12 PAX only. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
            ['name' => 'Cabana Daisy', 'slug' => 'cabana-daisy', 'price_daily' => 270, 'max_pax' => 20, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Spacious cabana with maximum 20 PAX capacity. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
            ['name' => 'Cabana Lily', 'slug' => 'cabana-lily', 'price_daily' => 270, 'max_pax' => 20, 'image' => 'images/cabanas/cabana-lily.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Large capacity cabana with maximum 20 PAX. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
            ['name' => 'Cabana Bestari Daily/Bermalam', 'slug' => 'cabana-bestari', 'price_daily' => 162, 'price_overnight' => 270, 'max_pax' => 6, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['fan','plugpoint','sink','river_side'], 'description' => 'Flexible cabana offering both daily (RM162) and overnight (RM270) options. Features fan, plugpoint, sink and riverside location. Check in 5PM for overnight stays.', 'allow_overnight' => true],
            ['name' => 'Cabana Cattleya', 'slug' => 'cabana-cattleya', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/cabana-cattleya.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful Area Azizah Cottage cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Ludisia', 'slug' => 'cabana-ludisia', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/cabana-ludisia.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful Area Azizah Cottage cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana Geranium', 'slug' => 'cabana-geranium', 'price_daily' => 162, 'max_pax' => 6, 'image' => 'images/cabanas/cabana-geranium.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Beautiful Area Azizah Cottage cabana with BBQ bin, fan, plugpoint, sink and riverside location. Perfect for families and small groups.', 'allow_overnight' => true],
            ['name' => 'Cabana White Tent', 'slug' => 'cabana-white-tent', 'price_daily' => 270, 'max_pax' => 15, 'image' => 'cabanas/cabanairis.jpg', 'features' => ['bbq_bin','fan','plugpoint','sink','river_side'], 'description' => 'Large capacity white tent cabana for bigger groups with maximum 15 PAX. Features BBQ bin, fan, plugpoint, sink and riverside location.', 'allow_overnight' => true],
        ];

        foreach ($cabanas as $c) {
            Cabana::create($c);
        }
    }
}
