<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Store a new payment
     */
    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'method' => 'required|string|in:fpx,toyyibpay,bank_transfer,cash',
        ]);

        try {
            $result = $this->paymentService->processPayment($request, $booking);

            if ($result['success']) {
                if (isset($result['toyyibpay_url'])) {
                    return redirect($result['toyyibpay_url']);
                }
                
                if (isset($result['redirect_url'])) {
                    return redirect($result['redirect_url']);
                }

                return redirect()->route('bookings.show', $booking->id)
                    ->with('success', 'Payment processed successfully!');
            }

            return back()->withErrors(['payment' => $result['error'] ?? 'Payment processing failed']);

        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            return back()->withErrors(['payment' => 'An error occurred while processing your payment. Please try again.']);
        }
    }

    /**
     * Process Stripe payment
     */
    public function processStripe(Payment $payment)
    {
        return view('payments.stripe', compact('payment'));
    }

    /**
     * Handle Stripe payment confirmation
     */
    public function confirmStripe(Request $request, Payment $payment)
    {
        $paymentIntentId = $request->input('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('bookings.show', $payment->booking_id)
                ->withErrors(['payment' => 'Payment confirmation failed']);
        }

        $result = $this->paymentService->confirmStripePayment($payment, $paymentIntentId);

        if ($result['success']) {
            return redirect()->route('bookings.show', $payment->booking_id)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        }

        return redirect()->route('bookings.show', $payment->booking_id)
            ->withErrors(['payment' => $result['error'] ?? 'Payment confirmation failed']);
    }

    /**
     * Process PayPal payment
     */
    public function processPayPal(Payment $payment)
    {
        return view('payments.paypal', compact('payment'));
    }

    /**
     * Process FPX payment
     */
    public function processFPX(Payment $payment)
    {
        return view('payments.fpx', compact('payment'));
    }


    /**
     * Process ToyyibPay payment
     */
    public function processToyyibPay(Payment $payment)
    {
        return view('payments.toyyibpay', compact('payment'));
    }

    /**
     * Show bank transfer instructions
     */
    public function bankTransferInstructions(Payment $payment)
    {
        return view('payments.bank-transfer', compact('payment'));
    }

    /**
     * Show cash payment instructions
     */
    public function cashInstructions(Payment $payment)
    {
        return view('payments.cash', compact('payment'));
    }

    /**
     * Handle payment gateway webhooks
     */
    public function webhook(Request $request, $gateway)
    {
        try {
            $payload = $request->getContent();
            $result = $this->paymentService->handleWebhook($gateway, $payload);

            if ($result['success']) {
                return response()->json(['status' => 'success'], 200);
            }

            return response()->json(['status' => 'error', 'message' => $result['error']], 400);

        } catch (\Exception $e) {
            Log::error("Webhook error for {$gateway}: " . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Manual payment confirmation (for admin)
     */
    public function confirmManual(Request $request, Payment $payment)
    {
        $request->validate([
            'reference' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $payment->update([
            'status' => 'paid',
            'reference' => $request->reference,
            'paid_at' => now(),
            'gateway_response' => ['notes' => $request->notes],
        ]);

        $payment->booking->update(['status' => 'confirmed']);

        return redirect()->route('bookings.show', $payment->booking_id)
            ->with('success', 'Payment confirmed manually!');
    }
}
