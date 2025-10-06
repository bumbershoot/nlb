

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold" style="color: #6d4c41;">Contact Us</h1>
                <p class="lead text-muted">Get in touch with us for bookings, inquiries, or support</p>
            </div>

            <!-- Main Contact Cards -->
            <div class="row g-4">
                <!-- Operation Hours Card -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, #6d4c41, #8d6e63);">
                        <div class="card-body p-5 text-white text-center">
                            <div class="mb-4">
                                <i class="fas fa-clock fa-3x mb-3"></i>
                                <h3 class="fw-bold mb-3">OPERATION HOURS</h3>
                            </div>
                            <div class="mb-4">
                                <h2 class="display-6 fw-bold text-warning mb-2">OPEN DAILY</h2>
                                <h1 class="display-4 fw-bold">8.30 AM - 5.00 PM</h1>
                            </div>
                            <p class="mb-0 opacity-75">7 days a week</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Contact Card -->
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, #25D366, #128C7E);">
                        <div class="card-body p-5 text-white text-center">
                            <div class="mb-4">
                                <i class="fab fa-whatsapp fa-3x mb-3"></i>
                                <h3 class="fw-bold mb-3">WHATSAPP NUMBER</h3>
                            </div>
                            <div class="mb-4">
                                <h2 class="display-5 fw-bold mb-3">019-980 2977</h2>
                                <h2 class="display-5 fw-bold">019-977 2977</h2>
                            </div>
                            <div class="mt-4">
                                <a href="https://wa.me/60199802977" target="_blank" class="btn btn-light btn-lg me-2 mb-2">
                                    <i class="fab fa-whatsapp me-2"></i>Chat Now (2977)
                                </a>
                                <a href="https://wa.me/60199772977" target="_blank" class="btn btn-outline-light btn-lg mb-2">
                                    <i class="fab fa-whatsapp me-2"></i>Chat Now (2977)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    .display-5 {
        font-size: 1.5rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/pages/contact.blade.php ENDPATH**/ ?>