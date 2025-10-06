

<?php $__env->startSection('title', 'Cabana Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">🏠 <?php echo e($cabana->name); ?></h1>
                <div>
                    <a href="<?php echo e(route('admin.cabanas.edit', $cabana)); ?>" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit Cabana
                    </a>
                    <a href="<?php echo e(route('admin.cabanas.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Cabanas
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Cabana Image -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php if($cabana->image): ?>
                                <img src="<?php echo e(str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image)); ?>" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px; width: 100%; object-fit: cover;"
                                     alt="<?php echo e($cabana->name); ?>">
                            <?php else: ?>
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No image available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Cabana Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Cabana Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Name</h6>
                                    <p class="fw-semibold"><?php echo e($cabana->name); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Slug</h6>
                                    <p class="fw-semibold"><?php echo e($cabana->slug); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Maximum Capacity</h6>
                                    <p class="fw-semibold"><?php echo e($cabana->max_pax); ?> pax</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Overnight Stays</h6>
                                    <p class="fw-semibold">
                                        <?php if($cabana->allow_overnight): ?>
                                            <span class="badge bg-success">Allowed</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Not Allowed</span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted">Description</h6>
                                    <p class="fw-semibold"><?php echo e($cabana->description ?: 'No description provided'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Daily Price</h6>
                                    <p class="fw-semibold text-success fs-4">RM <?php echo e(number_format($cabana->price_daily, 2)); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Overnight Price</h6>
                                    <p class="fw-semibold text-primary fs-4">
                                        <?php echo e($cabana->price_overnight ? 'RM ' . number_format($cabana->price_overnight, 2) : 'Not set'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <?php if($cabana->features): ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Features</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                    $features = is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true) ?? [];
                                ?>
                                <?php if(count($features) > 0): ?>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-primary">
                                                <?php switch($feature):
                                                    case ('fan'): ?>
                                                        <i class="fas fa-fan me-1"></i>Fan
                                                        <?php break; ?>
                                                    <?php case ('plugpoint'): ?>
                                                        <i class="fas fa-plug me-1"></i>Power Outlet
                                                        <?php break; ?>
                                                    <?php case ('river_side'): ?>
                                                        <i class="fas fa-water me-1"></i>River Side
                                                        <?php break; ?>
                                                    <?php case ('air_conditioning'): ?>
                                                        <i class="fas fa-snowflake me-1"></i>Air Conditioning
                                                        <?php break; ?>
                                                    <?php case ('wifi'): ?>
                                                        <i class="fas fa-wifi me-1"></i>WiFi
                                                        <?php break; ?>
                                                    <?php case ('parking'): ?>
                                                        <i class="fas fa-car me-1"></i>Parking
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <?php echo e(ucfirst(str_replace('_', ' ', $feature))); ?>

                                                <?php endswitch; ?>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No features specified</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">📊 Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 class="text-primary"><?php echo e($cabana->bookings_count ?? 0); ?></h4>
                                    <small class="text-muted">Total Bookings</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success"><?php echo e($cabana->max_pax); ?></h4>
                                    <small class="text-muted">Max Capacity</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">⚡ Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('admin.cabanas.edit', $cabana)); ?>" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Cabana
                                </a>
                                <a href="<?php echo e(route('cabanas.show', $cabana->slug)); ?>" class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>View Public Page
                                </a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Delete Cabana
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">📅 Recent Bookings</h6>
                        </div>
                        <div class="card-body">
                            <?php if($cabana->bookings && $cabana->bookings->count() > 0): ?>
                                <?php $__currentLoopData = $cabana->bookings->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <small class="fw-semibold">#<?php echo e($booking->id); ?></small>
                                            <br>
                                            <small class="text-muted"><?php echo e($booking->date_from); ?> - <?php echo e($booking->date_to); ?></small>
                                        </div>
                                        <span class="badge 
                                            <?php if($booking->status == 'confirmed'): ?> bg-success
                                            <?php elseif($booking->status == 'pending'): ?> bg-warning
                                            <?php elseif($booking->status == 'cancelled'): ?> bg-danger
                                            <?php else: ?> bg-secondary
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($booking->status)); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-muted text-center">No bookings yet</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Cabana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong><?php echo e($cabana->name); ?></strong>?</p>
                <?php if($cabana->bookings && $cabana->bookings->count() > 0): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This cabana has <?php echo e($cabana->bookings->count()); ?> booking(s). You cannot delete it until all bookings are cancelled or completed.
                    </div>
                <?php else: ?>
                    <p class="text-muted">This action cannot be undone.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <?php if($cabana->bookings && $cabana->bookings->count() == 0): ?>
                    <form action="<?php echo e(route('admin.cabanas.destroy', $cabana)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Delete Cabana</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/admin/cabanas/show.blade.php ENDPATH**/ ?>