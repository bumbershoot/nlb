

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Resort Dashboard</h1>
                <div class="text-muted">
                    <i class="fas fa-calendar me-2"></i><?php echo e(date('l, F j, Y')); ?>

                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <div class="text-primary">
                                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            </div>
                            <h3 class="text-primary"><?php echo e($recentBookings->count()); ?></h3>
                            <p class="text-muted mb-0">Recent Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <div class="text-success">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                            </div>
                            <h3 class="text-success"><?php echo e($monthlyBookings->count()); ?></h3>
                            <p class="text-muted mb-0">This Month</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <div class="text-info">
                                <i class="fas fa-users fa-2x mb-2"></i>
                            </div>
                            <h3 class="text-info"><?php echo e($totalCustomers ?? 0); ?></h3>
                            <p class="text-muted mb-0">Total Customers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <div class="text-warning">
                                <i class="fas fa-dollar-sign fa-2x mb-2"></i>
                            </div>
                            <h3 class="text-warning">RM <?php echo e(number_format($monthlyRevenue ?? 0, 2)); ?></h3>
                            <p class="text-muted mb-0">Monthly Revenue</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Bookings -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Bookings</h5>
                            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-sm btn-outline-primary">
                                View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if($recentBookings->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Cabana</th>
                                                <th>Check-in</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            <?php echo e(strtoupper(substr($booking->user->name, 0, 1))); ?>

                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold"><?php echo e($booking->user->name); ?></div>
                                                            <small class="text-muted"><?php echo e($booking->user->email); ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo e($booking->cabana->name); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($booking->date_from)->format('M d, Y')); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo e($booking->status === 'confirmed' ? 'success' : 
                                                        ($booking->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                                        <?php echo e(ucfirst($booking->status)); ?>

                                                    </span>
                                                </td>
                                                <td class="fw-semibold">RM <?php echo e(number_format($booking->total_price, 2)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No recent bookings</h5>
                                    <p class="text-muted">New bookings will appear here</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-calendar-check me-2"></i>View All Bookings
                                </a>
                                <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-outline-info">
                                    <i class="fas fa-users me-2"></i>Manage Customers
                                </a>
                                <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-success">
                                    <i class="fas fa-credit-card me-2"></i>Payment History
                                </a>
                                <a href="<?php echo e(route('admin.cabanas.index')); ?>" class="btn btn-outline-warning">
                                    <i class="fas fa-bed me-2"></i>Manage Cabanas
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Schedule -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Today's Schedule</h5>
                        </div>
                        <div class="card-body">
                            <?php if(isset($todayCheckIns) && $todayCheckIns->count() > 0): ?>
                                <h6 class="text-success mb-2">
                                    <i class="fas fa-sign-in-alt me-2"></i>Check-ins (<?php echo e($todayCheckIns->count()); ?>)
                                </h6>
                                <?php $__currentLoopData = $todayCheckIns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small><?php echo e($booking->user->name); ?></small>
                                    <small class="text-muted"><?php echo e($booking->cabana->name); ?></small>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <?php if(isset($todayCheckOuts) && $todayCheckOuts->count() > 0): ?>
                                <h6 class="text-danger mb-2 mt-3">
                                    <i class="fas fa-sign-out-alt me-2"></i>Check-outs (<?php echo e($todayCheckOuts->count()); ?>)
                                </h6>
                                <?php $__currentLoopData = $todayCheckOuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small><?php echo e($booking->user->name); ?></small>
                                    <small class="text-muted"><?php echo e($booking->cabana->name); ?></small>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <?php if((!isset($todayCheckIns) || $todayCheckIns->count() === 0) && (!isset($todayCheckOuts) || $todayCheckOuts->count() === 0)): ?>
                                <div class="text-center py-3">
                                    <i class="fas fa-calendar-day fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">No check-ins or check-outs today</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.875rem;
}

.card {
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 0.5rem;
}

.card-header {
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>