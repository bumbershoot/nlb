<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Cabana;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $cabana = Cabana::first();

        Booking::create([
            'user_id' => $user->id,
            'cabana_id' => $cabana->id,
            'date_from' => now()->toDateString(),
            'date_to' => now()->addDay()->toDateString(),
            'adults' => 2,
            'kids' => 1,
            'total_price' => 270,
            'status' => 'confirmed',
        ]);
    
    }
}
