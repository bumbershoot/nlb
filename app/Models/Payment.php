<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'method',
        'reference',
        'amount',
        'status',
        'gateway',
        'gateway_transaction_id',
        'gateway_payment_intent_id',
        'gateway_response',
        'gateway_fee',
        'currency',
        'paid_at',
        'failure_reason',
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'gateway_fee' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function isSuccessful()
    {
        return $this->status === 'paid' || $this->status === 'completed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isFailed()
    {
        return $this->status === 'failed' || $this->status === 'cancelled';
    }
}
