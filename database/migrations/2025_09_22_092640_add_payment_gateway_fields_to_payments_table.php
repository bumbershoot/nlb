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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('gateway')->default('manual'); // stripe, paypal, manual
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_payment_intent_id')->nullable();
            $table->json('gateway_response')->nullable();
            $table->decimal('gateway_fee', 8, 2)->default(0);
            $table->string('currency', 3)->default('MYR');
            $table->timestamp('paid_at')->nullable();
            $table->text('failure_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'gateway',
                'gateway_transaction_id',
                'gateway_payment_intent_id',
                'gateway_response',
                'gateway_fee',
                'currency',
                'paid_at',
                'failure_reason'
            ]);
        });
    }
};
