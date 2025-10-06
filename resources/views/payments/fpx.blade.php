@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-university me-2"></i>FPX Online Banking Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Summary</h6>
                        <p class="mb-1"><strong>Booking:</strong> #{{ $payment->booking->id }}</p>
                        <p class="mb-1"><strong>Cabana:</strong> {{ $payment->booking->cabana->name }}</p>
                        <p class="mb-0"><strong>Amount:</strong> RM {{ number_format($payment->amount, 2) }}</p>
                    </div>

                    <!-- FPX Payment Methods -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Supported Banks</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-primary mb-2"></i>
                                        <p class="small mb-0">Maybank2u</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-success mb-2"></i>
                                        <p class="small mb-0">CIMB Clicks</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-warning mb-2"></i>
                                        <p class="small mb-0">Public Bank</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-info mb-2"></i>
                                        <p class="small mb-0">RHB Bank</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-danger mb-2"></i>
                                        <p class="small mb-0">Hong Leong</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <div class="bank-option p-3 border rounded">
                                        <i class="fas fa-university fa-2x text-secondary mb-2"></i>
                                        <p class="small mb-0">AmBank</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FPX Payment Button -->
                    <div class="text-center mb-4">
                        <button id="fpx-btn" class="btn btn-primary btn-lg px-5" onclick="initiateFPXPayment()">
                            <i class="fas fa-university me-2"></i>Pay with FPX Online Banking
                        </button>
                    </div>

                    <div class="alert alert-warning">
                        <small><i class="fas fa-info-circle me-2"></i>You will be redirected to ToyyibPay's secure payment gateway to complete your FPX payment.</small>
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
function initiateFPXPayment() {
    // Show loading state
    const btn = document.getElementById('fpx-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Redirecting to FPX...';
    btn.disabled = true;

    // Redirect to ToyyibPay FPX payment
    setTimeout(() => {
        // In a real implementation, this would redirect to ToyyibPay with FPX channel
        window.location.href = '{{ route("payments.toyyibpay.process", $payment->id) }}';
    }, 1000);
}
</script>

<style>
.bank-option {
    transition: all 0.3s ease;
    cursor: pointer;
}

.bank-option:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #007bff !important;
}
</style>
@endsection
