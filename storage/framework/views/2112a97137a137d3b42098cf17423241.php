

<?php $__env->startSection('content'); ?>
<!-- Custom Styles for About Page -->
<style>
    .about-hero {
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }
    
    .about-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
    }
    
    .about-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .logo-container {
        text-align: center;
        margin-bottom: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
    }
    
    .logo-image {
        max-width: 300px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 1.5rem;
    }
    
    .mission-vision {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .stats-card {
        text-align: center;
        padding: 2rem;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #6d4c41;
        margin-bottom: 0.5rem;
    }
</style>

<div class="container py-5">
    <!-- Logo and Introduction -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="about-card text-center">
                <div class="logo-container">
                    <!-- Logo Image - You can replace this src with your actual logo path -->
                    <img src="<?php echo e(asset('images/nur-laman-bestari-logo.jpg')); ?>" 
                         alt="Nur Laman Bestari Eco Resort Logo" 
                         class="logo-image"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <!-- Fallback if logo image is not found -->
                    <div style="display: none; padding: 2rem; border: 2px dashed #6d4c41; border-radius: 10px;">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Logo will be displayed here</p>
                        <small class="text-muted">Please upload your logo to: public/images/nur-laman-bestari-logo.jpg</small>
                    </div>
                </div>
                
                <h1 class="display-5 mb-4" style="color: #6d4c41; font-family: 'Merriweather', serif;">
                    Nur Laman Bestari Eco Resort
                </h1>
                <p class="lead text-muted mb-4">
                    A premier eco resort and training facility nestled in the heart of nature, 
                    offering tranquility, comfort, and professional development opportunities.
                </p>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="about-card h-100">
                <div class="feature-icon mx-auto">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="text-center mb-3" style="color: #6d4c41;">Our Mission</h3>
                <p class="text-muted text-center">
                    To provide exceptional eco-friendly accommodation and world-class training facilities 
                    that inspire personal growth, foster team building, and create lasting memories in a 
                    sustainable natural environment.
                </p>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="about-card h-100">
                <div class="feature-icon mx-auto">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="text-center mb-3" style="color: #6d4c41;">Our Vision</h3>
                <p class="text-muted text-center">
                    To be the leading eco resort and training destination in Malaysia, recognized for 
                    our commitment to sustainability, excellence in service, and creating transformative 
                    experiences for our guests.
                </p>
            </div>
        </div>
    </div>

    <!-- Features & Services -->
    <div class="row mb-5 justify-content-center">
        <div class="col-12">
            <h2 class="text-center mb-5" style="color: #6d4c41;">What We Offer</h2>
        </div>
        
        <div class="col-lg-5 col-md-6 mb-4 mx-3">
            <div class="about-card text-center h-100">
                <div class="feature-icon mx-auto">
                    <i class="fas fa-home"></i>
                </div>
                <h4 style="color: #6d4c41;">Premium Cabanas</h4>
                <p class="text-muted">
                    Comfortable and well-equipped cabanas with modern amenities, 
                    perfect for families, groups, and corporate retreats.
                </p>
            </div>
        </div>
        
        <div class="col-lg-5 col-md-6 mb-4 mx-3">
            <div class="about-card text-center h-100">
                <div class="feature-icon mx-auto">
                    <i class="fas fa-leaf"></i>
                </div>
                <h4 style="color: #6d4c41;">Eco-Friendly</h4>
                <p class="text-muted">
                    Committed to sustainable practices and environmental conservation 
                    while providing exceptional guest experiences.
                </p>
            </div>
        </div>
    </div>

</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nurlaman/public_html/resources/views/pages/about.blade.php ENDPATH**/ ?>