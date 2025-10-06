@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-university me-2"></i>Bank Transfer Instructions</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>
                                <p class="mb-1"><strong>Payment Reference:</strong> {{ $payment->reference }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Amount to Transfer:</strong> <span class="fs-5 text-primary">RM {{ number_format($payment->amount, 2) }}</span></p>
                                <p class="mb-0"><strong>Currency:</strong> Malaysian Ringgit (MYR)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Transfer to Our Bank Account</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Bank Name:</strong></td>
                                            <td>Maybank Malaysia</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account Name:</strong></td>
                                            <td>Nur Laman Bestari Eco Resort</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account Number:</strong></td>
                                            <td class="text-primary fs-5">1234 5678 9012</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Swift Code:</strong></td>
                                            <td>MBBEMYKL</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-warning">
                                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notes:</h6>
                                        <ul class="mb-0 small">
                                            <li>Please include your <strong>Payment Reference: {{ $payment->reference }}</strong> in the transfer description</li>
                                            <li>Transfer the exact amount: <strong>RM {{ number_format($payment->amount, 2) }}</strong></li>
                                            <li>Keep your transfer receipt for verification</li>
                                            <li>Payment confirmation may take 1-2 business days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alternative Bank Options -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Alternative Bank Options</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>CIMB Bank</h6>
                                    <p class="small mb-1"><strong>Account:</strong> 8765 4321 0987</p>
                                    <p class="small mb-3"><strong>Account Name:</strong> Nur Laman Bestari Eco Resort</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Public Bank</h6>
                                    <p class="small mb-1"><strong>Account:</strong> 4567 8901 2345</p>
                                    <p class="small mb-3"><strong>Account Name:</strong> Nur Laman Bestari Eco Resort</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Receipt Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Upload Transfer Receipt (Optional)</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payments.confirm.manual', $payment->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="reference" class="form-label">Transfer Reference Number</label>
                                            <input type="text" class="form-control" id="reference" name="reference" placeholder="Enter your bank transfer reference number">
                                        </div>
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">Additional Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information about your transfer"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-2"></i>Submit Receipt Info
                                        </button>
                                        <p class="small text-muted mt-2">This will help us verify your payment faster</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="alert alert-light">
                        <h6><i class="fas fa-phone me-2"></i>Need Help?</h6>
                        <p class="mb-0">If you have any questions about the bank transfer, please contact us:</p>
                        <p class="mb-0"><strong>Phone:</strong> +60 12-345 6789 | <strong>Email:</strong> payments@nurlaman.com</p>
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
@endsection
