<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Invoice;
use App\Services\EinvoiceService;
use App\Services\ToyyibPayService;
use Illuminate\Http\Request;
use Exception;

class PaymentService
{
    public function __construct()
    {
        // Payment service initialization
    }

    /**
     * Process payment based on the selected method
     */
    public function processPayment(Request $request, Booking $booking)
    {
        $method = $request->input('method');

        switch ($method) {
            case 'fpx':
                return $this->processFPXPayment($request, $booking);
            case 'toyyibpay':
                return $this->processToyyibPayPayment($request, $booking);
            case 'bank_transfer':
                return $this->processBankTransferPayment($request, $booking);
            case 'cash':
                return $this->processCashPayment($request, $booking);
            default:
                throw new Exception('Invalid payment method selected');
        }
    }


    /**
     * Process FPX (Online Banking) payment via ToyyibPay
     */
    private function processFPXPayment(Request $request, Booking $booking)
    {
        try {
            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'method' => 'fpx',
                'gateway' => 'toyyibpay',
                'reference' => 'FPX-' . uniqid(),
                'amount' => $booking->total_price,
                'currency' => 'MYR',
                'status' => 'pending',
            ]);

            // Use ToyyibPayService to create bill with FPX payment channel
            $toyyibPayService = new ToyyibPayService();
            $response = $toyyibPayService->createBill($payment, $booking, '0'); // 0 = FPX only

            if ($response['success']) {
                $payment->update([
                    'gateway_transaction_id' => $response['bill_code'],
                    'gateway_response' => $response['response'],
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'redirect_url' => $response['payment_url']
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to create FPX payment via ToyyibPay: ' . ($response['error'] ?? 'Unknown error')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'FPX payment error: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Process ToyyibPay payment (Malaysian payment gateway) - All payment channels
     */
    private function processToyyibPayPayment(Request $request, Booking $booking)
    {
        try {
            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'method' => 'toyyibpay',
                'gateway' => 'toyyibpay',
                'reference' => 'TOYYIB-' . uniqid(),
                'amount' => $booking->total_price,
                'currency' => 'MYR',
                'status' => 'pending',
            ]);

            // Use ToyyibPayService to create bill with all payment channels
            $toyyibPayService = new ToyyibPayService();
            $response = $toyyibPayService->createBill($payment, $booking, '2'); // 2 = All channels (FPX, Credit Card, E-Wallet)

            if ($response['success']) {
                $payment->update([
                    'gateway_transaction_id' => $response['bill_code'],
                    'gateway_response' => $response['response'],
                ]);

                return [
                    'success' => true,
                    'payment' => $payment,
                    'redirect_url' => $response['payment_url']
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to create ToyyibPay bill: ' . ($response['error'] ?? 'Unknown error')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'ToyyibPay error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process bank transfer payment
     */
    private function processBankTransferPayment(Request $request, Booking $booking)
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method' => 'bank_transfer',
            'gateway' => 'manual',
            'reference' => 'BANK-' . uniqid(),
            'amount' => $booking->total_price,
            'currency' => 'MYR',
            'status' => 'pending',
        ]);

        return [
            'success' => true,
            'payment' => $payment,
            'redirect_url' => route('payments.bank-transfer.instructions', ['payment' => $payment->id])
        ];
    }

    /**
     * Process cash payment
     */
    private function processCashPayment(Request $request, Booking $booking)
    {
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method' => 'cash',
            'gateway' => 'manual',
            'reference' => 'CASH-' . uniqid(),
            'amount' => $booking->total_price,
            'currency' => 'MYR',
            'status' => 'pending',
        ]);

        return [
            'success' => true,
            'payment' => $payment,
            'redirect_url' => route('payments.cash.instructions', ['payment' => $payment->id])
        ];
    }


    /**
     * Handle webhook from payment gateways
     */
    public function handleWebhook($gateway, $payload)
    {
        switch ($gateway) {
            case 'toyyibpay':
                return $this->handleToyyibPayWebhook($payload);
            default:
                return ['success' => false, 'error' => 'Unknown gateway'];
        }
    }

    /**
     * Handle ToyyibPay webhook
     */
    private function handleToyyibPayWebhook($payload)
    {
        try {
            $toyyibPayService = new ToyyibPayService();
            $result = $toyyibPayService->handleWebhook($payload);
            
            // If payment was successful, create invoice and submit to e-invoice system
            if ($result['success'] && isset($result['status']) && $result['status'] === 'paid') {
                // Find the payment that was just updated
                parse_str($payload, $data);
                if (isset($data['billExternalReferenceNo'])) {
                    $payment = Payment::where('reference', $data['billExternalReferenceNo'])->first();
                    if ($payment && $payment->status === 'paid') {
                        $this->createInvoiceAndSubmitEinvoice($payment);
                    }
                }
            }
            
            return $result;

        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Create invoice and submit to e-invoice system
     */
    public function createInvoiceAndSubmitEinvoice(Payment $payment)
    {
        try {
            $booking = $payment->booking;
            
            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'customer_name' => $booking->name,
                'customer_email' => $booking->email,
                'customer_phone' => $booking->phone,
                'customer_address' => '', // Booking doesn't have address field
                'subtotal' => $booking->total_price,
                'tax_amount' => $this->calculateTax($booking->total_price),
                'discount_amount' => 0,
                'total_amount' => $booking->total_price + $this->calculateTax($booking->total_price),
                'currency' => 'MYR',
                'status' => 'paid',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->toDateString(),
                'paid_at' => now(),
                'line_items' => $this->prepareLineItems($booking),
            ]);

            // Submit to e-invoice system if auto-submit is enabled
            if (config('services.einvoice.auto_submit', false)) {
                $this->submitToEinvoice($invoice);
            }

            return $invoice;

        } catch (Exception $e) {
            \Log::error('Invoice creation failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Submit invoice to e-invoice system
     */
    protected function submitToEinvoice(Invoice $invoice)
    {
        try {
            $einvoiceService = new EinvoiceService();
            $einvoiceService->submitInvoice($invoice);
        } catch (Exception $e) {
            \Log::error('E-invoice submission failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            // Don't throw exception to avoid breaking the payment flow
        }
    }

    /**
     * Generate invoice number
     */
    protected function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastInvoice ? (int) substr($lastInvoice->invoice_number, -4) + 1 : 1;
        
        return sprintf('INV-%s%s-%04d', $year, $month, $sequence);
    }

    /**
     * Calculate tax amount (6% SST for Malaysia)
     */
    protected function calculateTax($amount)
    {
        return round($amount * 0.06, 2);
    }

    /**
     * Prepare line items for invoice
     */
    protected function prepareLineItems(Booking $booking)
    {
        return [
            [
                'description' => 'Cabana Booking - ' . $booking->cabana->name,
                'quantity' => 1,
                'unit_price' => $booking->total_price,
                'total_price' => $booking->total_price,
                'tax_rate' => 6,
                'tax_amount' => $this->calculateTax($booking->total_price),
            ]
        ];
    }
}
