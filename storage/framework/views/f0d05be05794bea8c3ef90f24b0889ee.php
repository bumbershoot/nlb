

<?php $__env->startSection('title', 'Manage Cabanas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">🏠 Manage Cabanas</h1>
                <div>
                    <a href="<?php echo e(route('admin.cabanas.create')); ?>" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add New Cabana
                    </a>
                    <a href="<?php echo e(route('cabanas.index')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Public Page
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Cabanas Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary"><?php echo e($cabanas->count()); ?></h3>
                            <p class="text-muted mb-0">Total Cabanas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success"><?php echo e($cabanas->where('allow_overnight', true)->count()); ?></h3>
                            <p class="text-muted mb-0">Overnight Available</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="text-info"><?php echo e($cabanas->sum('bookings_count')); ?></h3>
                            <p class="text-muted mb-0">Total Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning"><?php echo e($cabanas->avg('max_pax') ?? 0); ?></h3>
                            <p class="text-muted mb-0">Avg Capacity</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabanas List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Cabanas</h5>
                </div>
                <div class="card-body">
                    <?php if($cabanas->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $cabanas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <?php if($cabana->image): ?>
                                        <img src="<?php echo e(str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image)); ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo e($cabana->name); ?>"
                                             style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-home fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo e($cabana->name); ?></h5>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Capacity:</small>
                                            <span class="badge bg-info"><?php echo e($cabana->max_pax); ?> pax</span>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted">Bookings:</small>
                                            <span class="badge bg-success"><?php echo e($cabana->bookings_count ?? 0); ?> total</span>
                                        </div>

                                        <?php if($cabana->allow_overnight): ?>
                                            <div class="mb-2">
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-moon me-1"></i>Overnight Available
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="pricing mb-3">
                                            <?php if($cabana->price_daily): ?>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Daily:</small>
                                                    <strong class="text-success">RM <?php echo e(number_format($cabana->price_daily, 2)); ?></strong>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($cabana->price_overnight): ?>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Overnight:</small>
                                                    <strong class="text-primary">RM <?php echo e(number_format($cabana->price_overnight, 2)); ?></strong>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if($cabana->features): ?>
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">Features:</small>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <?php $__currentLoopData = (is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true)) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge bg-light text-dark">
                                                            <?php switch($feature):
                                                                case ('fan'): ?>
                                                                    <i class="fas fa-fan me-1"></i>Fan
                                                                    <?php break; ?>
                                                                <?php case ('plugpoint'): ?>
                                                                    <i class="fas fa-plug me-1"></i>Power
                                                                    <?php break; ?>
                                                                <?php case ('river_side'): ?>
                                                                    <i class="fas fa-water me-1"></i>Riverside
                                                                    <?php break; ?>
                                                                <?php default: ?>
                                                                    <?php echo e(ucfirst(str_replace('_', ' ', $feature))); ?>

                                                            <?php endswitch; ?>
                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-auto">
                                            <div class="d-grid gap-2">
                                                <a href="<?php echo e(route('cabanas.show', $cabana->slug)); ?>" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                <a href="<?php echo e(route('admin.bookings.index')); ?>?cabana=<?php echo e($cabana->id); ?>" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-calendar-alt me-2"></i>View Bookings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-home fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No cabanas found</h5>
                            <p class="text-muted">Cabanas will appear here once they are added to the system.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Stats Table -->
            <?php if($cabanas->count() > 0): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Cabana Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cabana</th>
                                    <th>Capacity</th>
                                    <th>Daily Rate</th>
                                    <th>Overnight Rate</th>
                                    <th>Total Bookings</th>
                                    <th>Features</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cabanas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($cabana->image): ?>
                                                <img src="<?php echo e(str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image)); ?>" 
                                                     class="rounded me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                     alt="<?php echo e($cabana->name); ?>">
                                            <?php else: ?>
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-home text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <strong><?php echo e($cabana->name); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($cabana->max_pax); ?> pax</span>
                                    </td>
                                    <td>
                                        <?php if($cabana->price_daily): ?>
                                            <span class="text-success fw-semibold">RM <?php echo e(number_format($cabana->price_daily, 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($cabana->price_overnight): ?>
                                            <span class="text-primary fw-semibold">RM <?php echo e(number_format($cabana->price_overnight, 2)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?php echo e($cabana->bookings_count ?? 0); ?></span>
                                    </td>
                                    <td>
                                        <?php if($cabana->features): ?>
                                            <div class="d-flex flex-wrap gap-1">
                                                <?php $__currentLoopData = array_slice((is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true)) ?? [], 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-light text-dark small">
                                                        <?php switch($feature):
                                                            case ('fan'): ?>
                                                                <i class="fas fa-fan"></i>
                                                                <?php break; ?>
                                                            <?php case ('plugpoint'): ?>
                                                                <i class="fas fa-plug"></i>
                                                                <?php break; ?>
                                                            <?php case ('river_side'): ?>
                                                                <i class="fas fa-water"></i>
                                                                <?php break; ?>
                                                            <?php default: ?>
                                                                <?php echo e(ucfirst($feature)); ?>

                                                        <?php endswitch; ?>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $features = is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true) ?? [];
                                                ?>
                                                <?php if(count($features) > 3): ?>
                                                    <span class="badge bg-secondary small">+<?php echo e(count($features) - 3); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.cabanas.show', $cabana)); ?>" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.cabanas.edit', $cabana)); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit Cabana">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Cabana"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal<?php echo e($cabana->id); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
<?php $__currentLoopData = $cabanas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabana): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="deleteModal<?php echo e($cabana->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Cabana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong><?php echo e($cabana->name); ?></strong>?</p>
                <?php if($cabana->bookings_count > 0): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This cabana has <?php echo e($cabana->bookings_count); ?> booking(s). You cannot delete it until all bookings are cancelled or completed.
                    </div>
                <?php else: ?>
                    <p class="text-muted">This action cannot be undone.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <?php if($cabana->bookings_count == 0): ?>
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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/admin/cabanas/index.blade.php ENDPATH**/ ?>