@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Cash Payment Instructions</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>
                                <p class="mb-1"><strong>Payment Reference:</strong> {{ $payment->reference }}</p>
                                <p class="mb-1"><strong>Guest Name:</strong> {{ $payment->booking->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Amount to Pay:</strong> <span class="fs-4 text-success">RM {{ number_format($payment->amount, 2) }}</span></p>
                                <p class="mb-1"><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($payment->booking->date_from)->format('d M Y') }}</p>
                                <p class="mb-0"><strong>Payment Method:</strong> Cash on Arrival</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Payment Instructions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Cash Payment Instructions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Payment Process:</h6>
                                    <ol>
                                        <li class="mb-2">
                                            <strong>Upon Arrival:</strong> Present this booking confirmation at our reception desk
                                        </li>
                                        <li class="mb-2">
                                            <strong>Payment:</strong> Pay the exact amount of <strong>RM {{ number_format($payment->amount, 2) }}</strong> in cash
                                        </li>
                                        <li class="mb-2">
                                            <strong>Receipt:</strong> You will receive an official receipt for your payment
                                        </li>
                                        <li class="mb-2">
                                            <strong>Check-in:</strong> Complete your check-in process and receive your room keys
                                        </li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-warning">
                                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Important:</h6>
                                        <ul class="small mb-0">
                                            <li>Please bring exact change if possible</li>
                                            <li>Payment must be made upon arrival</li>
                                            <li>Keep this confirmation for your records</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Contact -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Resort Location & Contact</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Address:</h6>
                                    <p class="mb-3">
                                        Nur Laman Bestari Eco Resort<br>
                                        Jalan Resort Bestari, Taman Laman<br>
                                        12345 Kuala Lumpur, Malaysia
                                    </p>
                                    
                                    <h6>Reception Hours:</h6>
                                    <p class="mb-0">
                                        <strong>Daily:</strong> 7:00 AM - 11:00 PM<br>
                                        <strong>Check-in:</strong> 3:00 PM onwards<br>
                                        <strong>Check-out:</strong> 12:00 PM
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Contact Information:</h6>
                                    <p class="mb-3">
                                        <i class="fas fa-phone me-2"></i><strong>Phone:</strong> +60 12-345 6789<br>
                                        <i class="fas fa-envelope me-2"></i><strong>Email:</strong> info@nurlaman.com<br>
                                        <i class="fab fa-whatsapp me-2"></i><strong>WhatsApp:</strong> +60 12-345 6789
                                    </p>
                                    
                                    <div class="alert alert-success">
                                        <small>
                                            <i class="fas fa-car me-2"></i><strong>Parking:</strong> Free parking available<br>
                                            <i class="fas fa-wifi me-2"></i><strong>WiFi:</strong> Complimentary internet access
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Confirmation -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-bookmark me-2"></i>Booking Confirmation</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Cabana:</strong> {{ $payment->booking->cabana->name }}</p>
                                    <p class="mb-1"><strong>Guests:</strong> {{ $payment->booking->pax }} {{ Str::plural('person', $payment->booking->pax) }}</p>
                                    <p class="mb-1"><strong>Nights:</strong> {{ \Carbon\Carbon::parse($payment->booking->date_from)->diffInDays(\Carbon\Carbon::parse($payment->booking->date_to)) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($payment->booking->date_from)->format('d M Y') }}</p>
                                    <p class="mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($payment->booking->date_to)->format('d M Y') }}</p>
                                    <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning text-dark">Pending Payment</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancellation Policy -->
                    <div class="alert alert-light">
                        <h6><i class="fas fa-calendar-times me-2"></i>Cancellation Policy</h6>
                        <p class="small mb-0">
                            Free cancellation up to 24 hours before check-in. Late cancellation or no-show may result in charges. 
                            For cancellations, please contact us at +60 12-345 6789.
                        </p>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn btn-outline-secondary me-3">
                            <i class="fas fa-arrow-left me-2"></i>Back to Booking
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-2"></i>Print Confirmation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, .alert-warning, .alert-light {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
