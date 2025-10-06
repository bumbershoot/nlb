@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>ToyyibPay Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Summary</h6>
                        <p class="mb-1"><strong>Booking:</strong> #{{ $payment->booking->id }}</p>
                        <p class="mb-1"><strong>Cabana:</strong> {{ $payment->booking->cabana->name }}</p>
                        <p class="mb-0"><strong>Amount:</strong> RM {{ number_format($payment->amount, 2) }}</p>
                    </div>

                    <!-- Payment Methods Available -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Available Payment Methods</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <i class="fas fa-mobile-alt fa-2x text-primary mb-2"></i>
                                    <p class="small">Online Banking</p>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-credit-card fa-2x text-success mb-2"></i>
                                    <p class="small">Credit/Debit Card</p>
                                </div>
                            </div>
                            <div class="row text-center mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center align-items-center flex-wrap">
                                        <span class="badge bg-light text-dark me-2 mb-1">Maybank2u</span>
                                        <span class="badge bg-light text-dark me-2 mb-1">CIMB Clicks</span>
                                        <span class="badge bg-light text-dark me-2 mb-1">Public Bank</span>
                                        <span class="badge bg-light text-dark me-2 mb-1">Hong Leong Bank</span>
                                        <span class="badge bg-light text-dark me-2 mb-1">RHB Bank</span>
                                        <span class="badge bg-light text-dark me-2 mb-1">AmBank</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ToyyibPay Payment Button -->
                    <div class="text-center mb-4">
                        @if($payment->status === 'pending')
                            <form action="{{ route('payments.store', $payment->booking) }}" method="POST" id="toyyibpay-form">
                                @csrf
                                <input type="hidden" name="method" value="toyyibpay">
                                <button type="submit" id="toyyibpay-btn" class="btn btn-warning btn-lg px-5">
                                    <i class="fas fa-mobile-alt me-2"></i>Pay with ToyyibPay
                                </button>
                            </form>
                        @elseif($payment->status === 'paid')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>Payment completed successfully!
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle me-2"></i>Payment failed. Please try again.
                            </div>
                            <form action="{{ route('payments.store', $payment->booking) }}" method="POST" id="toyyibpay-retry-form">
                                @csrf
                                <input type="hidden" name="method" value="toyyibpay">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-redo me-2"></i>Retry Payment
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle me-2"></i>You will be redirected to ToyyibPay's secure payment gateway to complete your payment.</small>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to payment forms
    const forms = document.querySelectorAll('#toyyibpay-form, #toyyibpay-retry-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            btn.disabled = true;
            
            // Re-enable button after 30 seconds as fallback
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 30000);
        });
    });
});
</script>
@endsection
