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
            $table->dropColumn(['google_calendar_event_id', 'calendar_synced_at', 'calendar_sync_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('google_calendar_event_id')->nullable();
            $table->timestamp('calendar_synced_at')->nullable();
            $table->boolean('calendar_sync_enabled')->default(true);
        });
    }
};
