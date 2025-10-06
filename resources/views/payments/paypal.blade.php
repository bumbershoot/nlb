@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fab fa-paypal me-2"></i>PayPal Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Summary</h6>
                        <p class="mb-1"><strong>Booking:</strong> #{{ $payment->booking->id }}</p>
                        <p class="mb-1"><strong>Cabana:</strong> {{ $payment->booking->cabana->name }}</p>
                        <p class="mb-0"><strong>Amount:</strong> RM {{ number_format($payment->amount, 2) }}</p>
                    </div>

                    <!-- PayPal Integration -->
                    <div id="paypal-button-container"></div>
                    
                    <div class="alert alert-warning mt-3">
                        <small><i class="fas fa-info-circle me-2"></i>PayPal integration is currently in development. Please use an alternative payment method.</small>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=MYR"></script>
<script>
// PayPal integration
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '{{ $payment->amount }}'
                },
                description: 'Booking #{{ $payment->booking->id }} - {{ $payment->booking->cabana->name }}'
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            // Redirect to success page or handle success
            window.location.href = "{{ route('bookings.show', $payment->booking->id) }}?paypal_success=1&order_id=" + data.orderID;
        });
    },
    onError: function(err) {
        console.error('PayPal error:', err);
        alert('An error occurred with PayPal payment. Please try again.');
    }
}).render('#paypal-button-container');
</script>
@endsection
