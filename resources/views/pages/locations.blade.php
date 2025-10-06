@extends('layouts.app')

@section('content')
<!-- Custom Styles for Locations Page -->
<style>
    .location-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
    }
    
    .location-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .location-icon {
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
    
    .map-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 400px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .contact-info {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateX(5px);
    }
    
    .contact-item i {
        width: 40px;
        height: 40px;
        background: #6d4c41;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.1rem;
    }
</style>

<div class="container py-5">
    <!-- Main Location Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="location-card text-center">
                <div class="location-icon mx-auto">
                    <i class="fas fa-leaf"></i>
                </div>
                <h2 class="h3 mb-3" style="color: #6d4c41;">Nur Laman Bestari Eco Resort</h2>
                <p class="text-muted mb-4">Experience tranquility and natural beauty at our premier eco resort</p>
                
                <!-- Address -->
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h6 class="mb-1" style="color: #6d4c41;">Address</h6>
                            <p class="mb-0">Jalan Sungai Tua, 68100 Batu Caves, Selangor</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-city"></i>
                        <div>
                            <h6 class="mb-1" style="color: #6d4c41;">Area</h6>
                            <p class="mb-0">Batu Caves, Selangor, Malaysia</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-route"></i>
                        <div>
                            <h6 class="mb-1" style="color: #6d4c41;">Access</h6>
                            <p class="mb-0">Easily accessible from Kuala Lumpur city center</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Row -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="location-card text-center h-100">
                <div class="location-icon mx-auto">
                    <i class="fas fa-tree"></i>
                </div>
                <h4 style="color: #6d4c41;">Natural Setting</h4>
                <p class="text-muted">Surrounded by lush greenery and peaceful river views</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="location-card text-center h-100">
                <div class="location-icon mx-auto">
                    <i class="fas fa-car"></i>
                </div>
                <h4 style="color: #6d4c41;">Easy Access</h4>
                <p class="text-muted">Convenient location near Batu Caves with ample parking</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="location-card text-center h-100">
                <div class="location-icon mx-auto">
                    <i class="fas fa-mountain"></i>
                </div>
                <h4 style="color: #6d4c41;">Scenic Views</h4>
                <p class="text-muted">Beautiful landscapes and fresh mountain air</p>
            </div>
        </div>
    </div>

    <!-- Google Maps Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4" style="color: #6d4c41;">Find Us Here</h3>
            <div class="map-container" style="height: 450px; padding: 0;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.4234567890123!2d101.68399999999999!3d3.2379999999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49c701efeae7%3A0x46b8a1b2b1234567!2sJalan%20Sungai%20Tua%2C%2068100%20Batu%20Caves%2C%20Selangor!5e0!3m2!1sen!2smy!4v1234567890123!5m2!1sen!2smy"
                    width="100%" 
                    height="100%" 
                    style="border:0; border-radius: 15px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <!-- Map Actions -->
            <div class="text-center mt-3">
                <a href="https://www.google.com/maps/search/Jalan+Sungai+Tua,+68100+Batu+Caves,+Selangor" 
                   target="_blank" 
                   class="btn me-2" 
                   style="background: #6d4c41; color: white; border-radius: 25px; padding: 0.75rem 1.5rem;">
                    <i class="fas fa-external-link-alt me-2"></i>Open in Google Maps
                </a>
                <a href="https://www.google.com/maps/dir//Jalan+Sungai+Tua,+68100+Batu+Caves,+Selangor" 
                   target="_blank" 
                   class="btn" 
                   style="background: #8d6e63; color: white; border-radius: 25px; padding: 0.75rem 1.5rem;">
                    <i class="fas fa-directions me-2"></i>Get Directions
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
