<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'booking_id',
        'payment_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'status',
        'issue_date',
        'due_date',
        'paid_at',
        'pdf_path',
        'line_items',
        // E-invoice fields
        'einvoice_number',
        'einvoice_status',
        'einvoice_reference',
        'einvoice_response',
        'einvoice_submitted_at',
        'einvoice_approved_at',
        'einvoice_rejection_reason',
        'einvoice_pdf_path',
        'einvoice_qr_code',
    ];

    protected $casts = [
        'line_items' => 'array',
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        // E-invoice casts
        'einvoice_response' => 'array',
        'einvoice_submitted_at' => 'datetime',
        'einvoice_approved_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastInvoice = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInvoice ? (int) substr($lastInvoice->invoice_number, -4) + 1 : 1;
        
        return sprintf('INV-%s%s-%04d', $year, $month, $sequence);
    }

    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function isOverdue()
    {
        return $this->status !== 'paid' && $this->due_date < today();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'secondary',
            'sent' => 'warning',
            'paid' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    // E-invoice methods
    public function getEinvoiceStatusColorAttribute()
    {
        return match($this->einvoice_status) {
            'pending' => 'secondary',
            'submitted' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    public function hasEinvoice()
    {
        return !empty($this->einvoice_number);
    }

    public function isEinvoiceApproved()
    {
        return $this->einvoice_status === 'approved';
    }

    public function isEinvoiceRejected()
    {
        return $this->einvoice_status === 'rejected';
    }

    public function canSubmitEinvoice()
    {
        return $this->status === 'paid' && 
               in_array($this->einvoice_status, ['pending', null]) &&
               $this->total_amount > 0;
    }

    public function getEinvoicePdfUrlAttribute()
    {
        if ($this->einvoice_pdf_path) {
            return asset('storage/' . $this->einvoice_pdf_path);
        }
        return null;
    }
}
