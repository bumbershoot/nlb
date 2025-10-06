

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Booking #<?php echo e($booking->id); ?></h4>
                </div>
                <div class="card-body">
                    <!-- Booking Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary"><?php echo e($booking->cabana->name); ?></h5>
                            <p class="mb-1"><i class="fas fa-calendar"></i> <strong>Check-in:</strong> <?php echo e(\Carbon\Carbon::parse($booking->date_from)->format('d M Y')); ?></p>
                            <p class="mb-1"><i class="fas fa-calendar"></i> <strong>Check-out:</strong> <?php echo e(\Carbon\Carbon::parse($booking->date_to)->format('d M Y')); ?></p>
                            <p class="mb-1"><i class="fas fa-users"></i> <strong>Guests:</strong> <?php echo e($booking->pax); ?> <?php echo e(Str::plural('person', $booking->pax)); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Guest Name:</strong> <?php echo e($booking->name); ?></p>
                            <p class="mb-1"><strong>Phone:</strong> <?php echo e($booking->phone); ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?php echo e($booking->email); ?></p>
                            <p class="mb-1"><strong>Nights:</strong> <?php echo e(\Carbon\Carbon::parse($booking->date_from)->diffInDays(\Carbon\Carbon::parse($booking->date_to))); ?></p>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="alert alert-light border">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-success mb-0">Total Amount</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4 class="text-success mb-0">RM <?php echo e(number_format($booking->total_price, 2)); ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-4">
                        <span class="badge 
                            <?php if($booking->status == 'pending'): ?> bg-warning text-dark
                            <?php elseif($booking->status == 'confirmed'): ?> bg-success
                            <?php elseif($booking->status == 'cancelled'): ?> bg-danger
                            <?php else: ?> bg-info
                            <?php endif; ?> fs-6 px-3 py-2">
                            <?php echo e(ucfirst($booking->status)); ?>

                        </span>
                    </div>

                    <?php if($booking->status == 'pending'): ?>
                        <!-- Success Message -->
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Payment Methods -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Choose Payment Method</h5>
                            </div>
                            <div class="card-body">
                                <?php if($errors->has('payment')): ?>
                                    <div class="alert alert-danger">
                                        <?php echo e($errors->first('payment')); ?>

                                    </div>
                                <?php endif; ?>

                                <!-- Payment Instructions -->
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Payment Required</h6>
                                    <p class="mb-2">To complete your booking, please select a payment method below and click "Proceed to Payment".</p>
                                    <small class="text-muted">
                                        <i class="fas fa-hand-pointer me-1"></i>
                                        Click on any payment method card to select it, then click the payment button.
                                    </small>
                                </div>

                                <form action="<?php echo e(route('payments.store', $booking->id)); ?>" method="POST" id="paymentForm">
                                    <?php echo csrf_field(); ?>
                                    
                                    <!-- Payment Method Cards -->
                                    <div class="row g-3">
                                        <!-- FPX (Online Banking) via ToyyibPay -->
                                        <div class="col-md-6">
                                            <div class="card payment-method-card h-100" onclick="selectPaymentMethod('fpx')">
                                                <div class="card-body text-center py-4">
                                                    <i class="fas fa-university fa-4x text-primary mb-3"></i>
                                                    <h5 class="text-primary">FPX Online Banking</h5>
                                                    <p class="text-muted mb-3">Direct online banking payment</p>
                                                    <div class="small text-muted">
                                                        <div class="mb-2">
                                                            <strong>Supported Banks:</strong>
                                                        </div>
                                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                                            <span class="badge bg-light text-dark">Maybank2u</span>
                                                            <span class="badge bg-light text-dark">CIMB Clicks</span>
                                                            <span class="badge bg-light text-dark">Public Bank</span>
                                                            <span class="badge bg-light text-dark">RHB Bank</span>
                                                            <span class="badge bg-light text-dark">Hong Leong</span>
                                                            <span class="badge bg-light text-dark">AmBank</span>
                                                        </div>
                                                        <div class="mt-2 small">
                                                            <i class="fas fa-shield-alt text-success me-1"></i>
                                                            <span class="text-success">Powered by ToyyibPay</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Cash Payment -->
                                        <div class="col-md-6">
                                            <div class="card payment-method-card h-100" onclick="selectPaymentMethod('cash')">
                                                <div class="card-body text-center py-4">
                                                    <i class="fas fa-money-bill-wave fa-4x text-secondary mb-3"></i>
                                                    <h5 class="text-secondary">Cash Payment</h5>
                                                    <p class="text-muted mb-3">Pay in cash upon arrival at the resort</p>
                                                    <div class="small text-muted">
                                                        <div class="mb-2">
                                                            <strong>Payment Instructions:</strong>
                                                        </div>
                                                        <div class="text-start d-inline-block">
                                                            • Pay at resort reception<br>
                                                            • Bring exact amount (RM <?php echo e(number_format($booking->total_price, 2)); ?>)<br>
                                                            • Keep booking reference: #<?php echo e($booking->id); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="method" id="selectedMethod" required>
                                    
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg px-5" id="paymentBtn" disabled>
                                            <i class="fas fa-credit-card me-2"></i>Proceed to Payment
                                        </button>
                                        <div class="mt-2">
                                            <small class="text-muted" id="paymentHint">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Please select a payment method first
                                            </small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php elseif($booking->status == 'confirmed' && $booking->payment): ?>
                        <!-- Payment Confirmation -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Payment Confirmed</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Payment Method:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $booking->payment->method))); ?></p>
                                <p><strong>Reference:</strong> <?php echo e($booking->payment->reference); ?></p>
                                <p><strong>Amount Paid:</strong> RM <?php echo e(number_format($booking->payment->amount, 2)); ?></p>
                                <?php if($booking->payment->paid_at): ?>
                                    <p><strong>Paid At:</strong> <?php echo e($booking->payment->paid_at->format('d M Y, h:i A')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
}

.payment-method-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.payment-method-card.selected {
    border-color: #007bff;
    background-color: #f8f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.2);
}

.payment-method-card::after {
    content: 'Click to select';
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,123,255,0.1);
    color: #007bff;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.payment-method-card:hover::after {
    opacity: 1;
}

.payment-method-card.selected::after {
    content: 'Selected ✓';
    background: rgba(40,167,69,0.1);
    color: #28a745;
    opacity: 1;
}

.payment-icons i {
    font-size: 1.5rem;
    margin: 0 5px;
    color: #666;
}
</style>

<script>
function selectPaymentMethod(method) {
    // Remove selected class from all cards
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Set the hidden input value
    document.getElementById('selectedMethod').value = method;
    
    // Enable the payment button and update hint
    const paymentBtn = document.getElementById('paymentBtn');
    const paymentHint = document.getElementById('paymentHint');
    
    paymentBtn.disabled = false;
    paymentBtn.classList.remove('btn-success');
    paymentBtn.classList.add('btn-primary');
    
    paymentHint.innerHTML = '<i class="fas fa-check-circle me-1 text-success"></i>Payment method selected - Ready to proceed!';
    paymentHint.className = 'mt-2 small text-success';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\bookingresort\resources\views/bookings/show.blade.php ENDPATH**/ ?>