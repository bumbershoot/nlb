<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $booking = Booking::first();

        if ($booking) {
            Payment::create([
                'booking_id' => $booking->id,
                'method' => 'ToyyibPay',
                'reference' => 'TP123456',
                'amount' => $booking->total_price,
                'status' => 'paid',
            ]);
        }
    }
}
