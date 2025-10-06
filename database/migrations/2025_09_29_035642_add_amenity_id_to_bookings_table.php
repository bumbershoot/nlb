<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('amenity_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('booking_type')->default('cabana'); // 'cabana' or 'amenity'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['amenity_id']);
            $table->dropColumn(['amenity_id', 'booking_type']);
        });
    }
};