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
        Schema::create('cabanas', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Cabana Iris, Cabana Royal, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_daily', 8, 2)->nullable();
            $table->decimal('price_overnight', 8, 2)->nullable();
            $table->integer('max_pax')->default(6);
            $table->boolean('allow_overnight')->default(false);
            $table->json('features')->nullable(); // ["fan","plugpoint","river_side"]
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabanas');
    }
};
