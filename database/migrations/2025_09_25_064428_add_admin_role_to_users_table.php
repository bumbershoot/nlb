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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('admin_role', ['super_admin', 'manager', 'staff', 'read_only'])->nullable()->after('role');
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active')->after('admin_role');
            $table->string('invited_by')->nullable()->after('status');
            $table->timestamp('invited_at')->nullable()->after('invited_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['admin_role', 'status', 'invited_by', 'invited_at']);
        });
    }
};
