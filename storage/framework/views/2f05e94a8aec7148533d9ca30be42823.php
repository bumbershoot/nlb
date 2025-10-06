

<?php $__env->startSection('title', 'Booking Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Professional Header -->
            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #6d4c41 0%, #8d6e63 100%);">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 text-white mb-1">
                                <i class="fas fa-calendar-check me-3"></i>Booking Management
                            </h1>
                            <p class="text-white-50 mb-0">Manage all resort reservations and guest bookings</p>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-building me-2"></i>
                            <span class="small">Nur Laman Bestari Eco Resort</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-3"></i>
                        <div>
                            <strong>Success!</strong> <?php echo e(session('success')); ?>

                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Warning Message -->
            <?php if(session('warning')): ?>
                <div class="alert alert-warning border-0 shadow-sm alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle text-warning me-3"></i>
                        <div>
                            <strong>Warning!</strong> <?php echo e(session('warning')); ?>

                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Google Calendar Info -->
            <div class="alert alert-info border-0 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar-plus text-info me-3"></i>
                    <div>
                        <strong>Google Calendar Integration:</strong> When you confirm a booking, it will automatically appear in your Google Calendar with all booking details!
                    </div>
                </div>
            </div>

            <!-- Quick Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <h4 class="text-primary mb-1"><?php echo e(isset($bookings) ? $bookings->count() : 0); ?></h4>
                            <small class="text-muted">Total Bookings</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-warning mb-2">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h4 class="text-warning mb-1"><?php echo e(isset($bookings) ? $bookings->where('status', 'pending')->count() : 0); ?></h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h4 class="text-success mb-1"><?php echo e(isset($bookings) ? $bookings->where('status', 'confirmed')->count() : 0); ?></h4>
                            <small class="text-muted">Confirmed</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-info mb-2">
                                <i class="fas fa-flag-checkered fa-2x"></i>
                            </div>
                            <h4 class="text-info mb-1"><?php echo e(isset($bookings) ? $bookings->where('status', 'completed')->count() : 0); ?></h4>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Bookings Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="fas fa-list-alt text-primary me-2"></i>All Resort Bookings
                            </h5>
                            <small class="text-muted">Manage and track all guest reservations</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if(isset($bookings) && $bookings->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 py-3 px-4">
                                            <i class="fas fa-user text-muted me-2"></i>Customer
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-home text-muted me-2"></i>Cabana
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-calendar-plus text-muted me-2"></i>Check-in
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-calendar-minus text-muted me-2"></i>Check-out
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-users text-muted me-2"></i>Guests
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-dollar-sign text-muted me-2"></i>Total
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-flag text-muted me-2"></i>Status
                                        </th>
                                        <th class="border-0 py-3">
                                            <i class="fas fa-cogs text-muted me-2"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-bottom">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-professional me-3">
                                                    <?php echo e(strtoupper(substr($booking->user->name ?? $booking->name, 0, 1))); ?>

                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark"><?php echo e($booking->user->name ?? $booking->name); ?></div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-envelope me-1"></i><?php echo e($booking->user->email ?? $booking->email); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-home me-1"></i><?php echo e($booking->cabana->name); ?>

                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-medium"><?php echo e(\Carbon\Carbon::parse($booking->date_from)->format('M d, Y')); ?></div>
                                            <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($booking->date_from)->format('l')); ?></small>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-medium"><?php echo e(\Carbon\Carbon::parse($booking->date_to)->format('M d, Y')); ?></div>
                                            <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($booking->date_to)->format('l')); ?></small>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-info text-white">
                                                <i class="fas fa-users me-1"></i><?php echo e($booking->pax); ?>

                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-bold text-success fs-6">RM <?php echo e(number_format($booking->total_price, 2)); ?></div>
                                        </td>
                                        <td class="py-3">
                                            <?php
                                                $statusConfig = [
                                                    'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Pending'],
                                                    'confirmed' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Confirmed'],
                                                    'completed' => ['class' => 'info', 'icon' => 'flag-checkered', 'text' => 'Completed'],
                                                    'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Cancelled']
                                                ];
                                                $config = $statusConfig[$booking->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => ucfirst($booking->status)];
                                            ?>
                                            <span class="badge bg-<?php echo e($config['class']); ?> px-3 py-2">
                                                <i class="fas fa-<?php echo e($config['icon']); ?> me-1"></i><?php echo e($config['text']); ?>

                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-edit me-1"></i>Change Status
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($booking->status !== 'pending'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.bookings.update-status', $booking)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="pending">
                                                                <button type="submit" class="dropdown-item text-warning">
                                                                    <i class="fas fa-clock me-2"></i>Set to Pending
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($booking->status !== 'confirmed'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.bookings.update-status', $booking)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check-circle me-2"></i>Confirm Booking
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($booking->status !== 'cancelled'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.bookings.update-status', $booking)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-times-circle me-2"></i>Cancel Booking
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($booking->status !== 'completed'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.bookings.update-status', $booking)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit" class="dropdown-item text-info">
                                                                    <i class="fas fa-flag-checkered me-2"></i>Mark as Completed
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if(method_exists($bookings, 'links')): ?>
                            <div class="mt-3">
                                <?php echo e($bookings->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
                            </div>
                            <h4 class="text-muted mb-3">No Bookings Found</h4>
                            <p class="text-muted mb-4">
                                When customers make reservations, they will appear here for you to manage.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="<?php echo e(route('cabanas.index')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>View Public Cabanas
                                </a>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Professional Avatar */
.avatar-professional {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #6d4c41 0%, #8d6e63 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 2px 8px rgba(109, 76, 65, 0.3);
}

/* Professional Cards */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

/* Table Enhancements */
.table thead th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    background-color: #f8f9fa !important;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(109, 76, 65, 0.05);
    transform: scale(1.01);
}

/* Professional Badges */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

/* Button Enhancements */
.btn {
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    pointer-events: auto;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}


/* Modal Enhancements */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
    background-color: rgba(0, 0, 0, 0.6);
}

.modal-content {
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 1056 !important;
}

.modal-body {
    position: relative;
    z-index: 1057 !important;
}

/* Simple Form Styling */
.form-select {
    cursor: pointer;
}

.form-select:focus {
    border-color: #6d4c41;
    box-shadow: 0 0 0 0.2rem rgba(109, 76, 65, 0.25);
}

.form-select option {
    padding: 8px;
    background-color: white;
    color: #333;
}

/* Background Pattern */
body {
    background-image: 
        radial-gradient(circle at 25% 25%, rgba(109, 76, 65, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(141, 110, 99, 0.05) 0%, transparent 50%);
}

/* Professional Stats Cards */
.card-body {
    transition: all 0.3s ease;
}

.card:hover .card-body {
    background: linear-gradient(135deg, rgba(109, 76, 65, 0.05) 0%, rgba(141, 110, 99, 0.05) 100%);
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .avatar-professional {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .table {
        font-size: 0.85rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.4rem 0.6rem;
    }
}

/* Loading Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card, .table tbody tr {
    animation: fadeInUp 0.6s ease forwards;
}

.table tbody tr:nth-child(even) {
    animation-delay: 0.1s;
}

.table tbody tr:nth-child(odd) {
    animation-delay: 0.2s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Booking management loaded - View Only Mode');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/admin/bookings/index.blade.php ENDPATH**/ ?>