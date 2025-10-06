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
        Schema::table('invoices', function (Blueprint $table) {
            // E-Invoice specific fields
            $table->string('einvoice_number')->nullable()->unique();
            $table->string('einvoice_status')->default('pending'); // pending, submitted, approved, rejected
            $table->string('einvoice_reference')->nullable();
            $table->json('einvoice_response')->nullable();
            $table->timestamp('einvoice_submitted_at')->nullable();
            $table->timestamp('einvoice_approved_at')->nullable();
            $table->text('einvoice_rejection_reason')->nullable();
            $table->string('einvoice_pdf_path')->nullable();
            $table->string('einvoice_qr_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'einvoice_number',
                'einvoice_status',
                'einvoice_reference',
                'einvoice_response',
                'einvoice_submitted_at',
                'einvoice_approved_at',
                'einvoice_rejection_reason',
                'einvoice_pdf_path',
                'einvoice_qr_code'
            ]);
        });
    }
};
