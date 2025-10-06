

<?php $__env->startSection('title', 'Edit Cabana'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">✏️ Edit Cabana: <?php echo e($cabana->name); ?></h1>
                <div>
                    <a href="<?php echo e(route('admin.cabanas.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Cabanas
                    </a>
                </div>
            </div>

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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cabana Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.cabanas.update', $cabana)); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <!-- Basic Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Basic Information</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Cabana Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="name" name="name" value="<?php echo e(old('name', $cabana->name)); ?>" required>
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="max_pax" class="form-label">Maximum Capacity (Pax) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control <?php $__errorArgs = ['max_pax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="max_pax" name="max_pax" value="<?php echo e(old('max_pax', $cabana->max_pax)); ?>" 
                                                   min="1" max="50" required>
                                            <?php $__errorArgs = ['max_pax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                      id="description" name="description" rows="3"><?php echo e(old('description', $cabana->description)); ?></textarea>
                                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Pricing</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price_daily" class="form-label">Daily Price (RM) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control <?php $__errorArgs = ['price_daily'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="price_daily" name="price_daily" value="<?php echo e(old('price_daily', $cabana->price_daily)); ?>" 
                                                   step="0.01" min="0" required>
                                            <?php $__errorArgs = ['price_daily'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price_overnight" class="form-label">Overnight Price (RM)</label>
                                            <input type="number" class="form-control <?php $__errorArgs = ['price_overnight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="price_overnight" name="price_overnight" value="<?php echo e(old('price_overnight', $cabana->price_overnight)); ?>" 
                                                   step="0.01" min="0">
                                            <?php $__errorArgs = ['price_overnight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Features</h6>
                                        <?php
                                            $currentFeatures = is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true) ?? [];
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="fan" id="feature_fan"
                                                           <?php echo e(in_array('fan', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_fan">
                                                        <i class="fas fa-fan me-1"></i>Fan
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="plugpoint" id="feature_plugpoint"
                                                           <?php echo e(in_array('plugpoint', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_plugpoint">
                                                        <i class="fas fa-plug me-1"></i>Power Outlet
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="river_side" id="feature_river_side"
                                                           <?php echo e(in_array('river_side', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_river_side">
                                                        <i class="fas fa-water me-1"></i>River Side
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="air_conditioning" id="feature_ac"
                                                           <?php echo e(in_array('air_conditioning', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_ac">
                                                        <i class="fas fa-snowflake me-1"></i>Air Conditioning
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="wifi" id="feature_wifi"
                                                           <?php echo e(in_array('wifi', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_wifi">
                                                        <i class="fas fa-wifi me-1"></i>WiFi
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="parking" id="feature_parking"
                                                           <?php echo e(in_array('parking', $currentFeatures) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="feature_parking">
                                                        <i class="fas fa-car me-1"></i>Parking
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Settings</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allow_overnight" id="allow_overnight" value="1"
                                                   <?php echo e($cabana->allow_overnight ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="allow_overnight">
                                                Allow Overnight Stays
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Image</h6>
                                        <?php if($cabana->image): ?>
                                            <div class="mb-3">
                                                <label class="form-label">Current Image</label>
                                                <div>
                                                    <img src="<?php echo e(str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image)); ?>" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                                         alt="<?php echo e($cabana->name); ?>">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Update Image</label>
                                            <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="image" name="image" accept="image/*">
                                            <div class="form-text">Upload a new image to replace the current one (max 2MB)</div>
                                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Cabana
                                    </button>
                                    <a href="<?php echo e(route('admin.cabanas.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Help Panel -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">📊 Cabana Statistics</h6>
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

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">⚠️ Important</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Changes will affect future bookings
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Existing bookings will keep old prices
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Test changes before going live
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/admin/cabanas/edit.blade.php ENDPATH**/ ?>