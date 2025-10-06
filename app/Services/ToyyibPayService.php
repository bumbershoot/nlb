<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ToyyibPayService
{
    protected $userSecretKey;
    protected $categoryCode;
    protected $mode;
    protected $webhookSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->userSecretKey = config('services.toyyibpay.user_secret_key');
        $this->categoryCode = config('services.toyyibpay.category_code');
        $this->mode = config('services.toyyibpay.mode', 'sandbox');
        $this->webhookSecret = config('services.toyyibpay.webhook_secret');
        
        // Set base URL based on mode
        $this->baseUrl = $this->mode === 'production' 
            ? 'https://toyyibpay.com' 
            : 'https://dev.toyyibpay.com';
    }

    /**
     * Create a bill in ToyyibPay
     */
    public function createBill(Payment $payment, Booking $booking, $paymentChannel = '2')
    {
        // Ensure relationships are loaded
        $booking->load(['cabana', 'amenity']);
        
        try {
            $billData = [
                'userSecretKey' => $this->userSecretKey,
                'categoryCode' => $this->categoryCode,
                'billName' => 'Booking #' . $booking->id,
                'billDescription' => 'Resort Booking - ' . ($booking->booking_type === 'cabana' ? ($booking->cabana->name ?? 'Cabana') : ($booking->amenity->name ?? 'Amenity')) . ' for ' . $booking->name,
                'billPriceSetting' => 1, // 1 = Fixed price
                'billPayorInfo' => 1, // 1 = Enable payor info collection
                'billAmount' => $booking->total_price * 100, // ToyyibPay uses cents
                'billReturnUrl' => route('bookings.show', $booking->id),
                'billCallbackUrl' => route('payments.webhook', 'toyyibpay'),
                'billExternalReferenceNo' => $payment->reference,
                'billTo' => $booking->name,
                'billEmail' => $booking->email,
                'billPhone' => $booking->phone,
                'billSplitPayment' => 0,
                'billPaymentChannel' => $paymentChannel, // 0 = FPX, 1 = Credit Card, 2 = Both
                'billContentEmail' => 'Thank you for your booking at Nur Laman Bestari Eco Resort!' . "\n\n" .
                    'Booking Details:' . "\n" .
                    '• Booking ID: #' . $booking->id . "\n" .
                    '• Item: ' . ($booking->booking_type === 'cabana' ? $booking->cabana->name : $booking->amenity->name) . "\n" .
                    '• Check-in: ' . $booking->date_from . ' at ' . ($booking->check_in_time ?: '15:00') . "\n" .
                    '• Check-out: ' . $booking->date_to . ' at ' . ($booking->check_out_time ?: '11:00') . "\n" .
                    '• Guests: ' . $booking->pax . ' adults' . "\n\n" .
                    'We look forward to welcoming you to our resort!',
                'billChargeToCustomer' => 1, // 1 = Charge processing fee to customer
            ];

            // Debug the description
            $description = 'Resort Booking - ' . ($booking->booking_type === 'cabana' ? ($booking->cabana->name ?? 'Cabana') : ($booking->amenity->name ?? 'Amenity')) . ' for ' . $booking->name;
            Log::info('ToyyibPay Description Debug', [
                'description' => $description,
                'description_length' => strlen($description),
                'booking_type' => $booking->booking_type,
                'cabana_name' => $booking->booking_type === 'cabana' ? $booking->cabana->name : 'N/A',
                'amenity_name' => $booking->booking_type === 'amenity' ? $booking->amenity->name : 'N/A',
                'booking_name' => $booking->name
            ]);

            Log::info('Creating ToyyibPay bill', [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
                'amount' => $billData['billAmount']
            ]);

            $response = Http::asForm()->post($this->baseUrl . '/index.php/api/createBill', $billData);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData[0]['BillCode'])) {
                    Log::info('ToyyibPay bill created successfully', [
                        'bill_code' => $responseData[0]['BillCode'],
                        'payment_id' => $payment->id
                    ]);

                    return [
                        'success' => true,
                        'bill_code' => $responseData[0]['BillCode'],
                        'payment_url' => $this->baseUrl . '/' . $responseData[0]['BillCode'],
                        'response' => $responseData[0]
                    ];
                }
            }

            Log::error('ToyyibPay bill creation failed', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return [
                'success' => false,
                'error' => 'Failed to create ToyyibPay bill: ' . $response->body()
            ];

        } catch (Exception $e) {
            Log::error('ToyyibPay bill creation exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get bill details from ToyyibPay
     */
    public function getBillDetails($billCode)
    {
        try {
            $response = Http::asForm()->post($this->baseUrl . '/index.php/api/getBillTransactions', [
                'userSecretKey' => $this->userSecretKey,
                'billCode' => $billCode
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to get bill details: ' . $response->body()
            ];

        } catch (Exception $e) {
            Log::error('ToyyibPay get bill details exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Handle ToyyibPay webhook callback
     */
    public function handleWebhook($payload)
    {
        try {
            Log::info('ToyyibPay Webhook Received', ['payload' => $payload]);

            // Parse the payload (ToyyibPay sends form data)
            parse_str($payload, $data);
            
            // Verify webhook signature if webhook secret is configured
            if ($this->webhookSecret && !$this->verifyWebhookSignature($payload, $data)) {
                Log::warning('ToyyibPay webhook signature verification failed');
                return ['success' => false, 'error' => 'Invalid webhook signature'];
            }

            if (isset($data['billExternalReferenceNo'])) {
                $payment = Payment::where('reference', $data['billExternalReferenceNo'])->first();
                
                if ($payment) {
                    // Update payment based on status
                    if (isset($data['billpaymentStatus']) && $data['billpaymentStatus'] == '1') {
                        // Payment successful
                        $payment->update([
                            'status' => 'paid',
                            'gateway_transaction_id' => $data['billCode'] ?? null,
                            'paid_at' => now(),
                            'gateway_response' => $data,
                        ]);

                        // Update booking status
                        $payment->booking->update(['status' => 'confirmed']);

                        Log::info('ToyyibPay Payment Successful', [
                            'bill_code' => $data['billCode'] ?? null,
                            'payment_id' => $payment->id,
                            'booking_id' => $payment->booking_id
                        ]);

                        return ['success' => true, 'status' => 'paid'];

                    } elseif (isset($data['billpaymentStatus']) && $data['billpaymentStatus'] == '3') {
                        // Payment failed
                        $payment->update([
                            'status' => 'failed',
                            'failure_reason' => 'Payment failed via ToyyibPay',
                            'gateway_response' => $data,
                        ]);

                        Log::info('ToyyibPay Payment Failed', [
                            'bill_code' => $data['billCode'] ?? null,
                            'payment_id' => $payment->id
                        ]);

                        return ['success' => true, 'status' => 'failed'];
                    }
                } else {
                    Log::warning('ToyyibPay webhook: Payment not found', [
                        'reference' => $data['billExternalReferenceNo']
                    ]);
                }
            }

            return ['success' => true, 'status' => 'processed'];

        } catch (Exception $e) {
            Log::error('ToyyibPay webhook handling exception: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Exception occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify webhook signature
     */
    private function verifyWebhookSignature($payload, $data)
    {
        if (!$this->webhookSecret) {
            return true; // Skip verification if no secret is configured
        }

        // ToyyibPay webhook signature verification
        // This is a basic implementation - adjust based on ToyyibPay's actual signature method
        $expectedSignature = hash_hmac('sha256', $payload, $this->webhookSecret);
        $receivedSignature = $data['signature'] ?? '';

        return hash_equals($expectedSignature, $receivedSignature);
    }

    /**
     * Get payment methods available
     */
    public function getPaymentMethods()
    {
        return [
            'fpx' => 'Online Banking (FPX)',
            'credit_card' => 'Credit/Debit Card'
        ];
    }

    /**
     * Check if ToyyibPay is properly configured
     */
    public function isConfigured()
    {
        return !empty($this->userSecretKey) && !empty($this->categoryCode);
    }

    /**
     * Get configuration status
     */
    public function getConfigurationStatus()
    {
        return [
            'configured' => $this->isConfigured(),
            'mode' => $this->mode,
            'user_secret_key' => !empty($this->userSecretKey) ? 'Set' : 'Not set',
            'category_code' => !empty($this->categoryCode) ? 'Set' : 'Not set',
            'webhook_secret' => !empty($this->webhookSecret) ? 'Set' : 'Not set',
            'base_url' => $this->baseUrl
        ];
    }
}
