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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Stone Table Set, BBQ Area, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_per_booking', 8, 2);
            $table->integer('max_pax')->default(5);
            $table->time('operating_hours_start')->default('09:00:00');
            $table->time('operating_hours_end')->default('17:00:00');
            $table->json('features')->nullable(); // ["bbq_bin","power_outlet","seating"]
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};