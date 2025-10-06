@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <!-- Stone Table Sets Section -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-3" style="color: #6d4c41;">
                        <i class="fas fa-utensils me-3"></i>Stone Table Sets
                    </h2>
                    <p class="lead text-muted">Perfect for outdoor dining and BBQ experiences</p>
                    <div class="decoration-line mx-auto" 
                         style="width: 80px; height: 3px; background: linear-gradient(90deg, #6d4c41, #8d6e63); border-radius: 2px;"></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" 
                     style="border-radius: 25px; overflow: hidden; background: linear-gradient(145deg, #ffffff, #fafbfc);">
                    <div class="row g-0">
                        <!-- Image Section -->
                        <div class="col-md-6">
                            <div class="image-container h-100 position-relative d-flex align-items-center justify-content-center" 
                                 style="min-height: 400px; overflow: hidden; padding: 20px;">
                                <img src="{{ asset('images/amenities/anjung.jpg') }}" 
                                     alt="Anjung Bestari Stone Table Set" 
                                     class="img-fluid rounded shadow"
                                     style="max-width: 90%; max-height: 350px; object-fit: contain;">
                                <!-- Image overlay -->
                                <div class="position-absolute top-0 start-0 w-100 h-100" 
                                     style="background: linear-gradient(135deg, rgba(109,76,65,0.05), rgba(141,110,99,0.05)); pointer-events: none;"></div>
                                <!-- Decorative corner -->
                                <div class="position-absolute top-0 start-0" 
                                     style="width: 0; height: 0; border-left: 40px solid #6d4c41; border-bottom: 40px solid transparent; opacity: 0.2;"></div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="col-md-6">
                            <div class="card-body p-5 h-100 d-flex flex-column justify-content-center">
                                <div class="mb-4">
                                    <div class="badge px-3 py-2 mb-3" 
                                         style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                                color: white; 
                                                border-radius: 20px; 
                                                font-size: 0.9rem; 
                                                font-weight: 600;">
                                        <i class="fas fa-star me-1"></i>ANJUNG BESTARI
                                    </div>
                                    <h3 class="card-title fw-bold mb-3" style="color: #4e342e; font-size: 1.8rem;">
                                        Stone Table Set
                                    </h3>
                                    <h4 class="text-success fw-bold mb-4" style="font-size: 1.6rem;">
                                        <i class="fas fa-tag me-2"></i>RM 54 <small class="text-muted fw-normal">per table set</small>
                                    </h4>
                                </div>

                                <!-- Features -->
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3" style="color: #6d4c41;">
                                        <i class="fas fa-check-circle me-2"></i>What's Included:
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="feature-item d-flex align-items-center p-3" 
                                                 style="background: rgba(109,76,65,0.05); border-radius: 15px; border-left: 4px solid #6d4c41;">
                                                <i class="fas fa-utensils fa-lg me-3" style="color: #6d4c41;"></i>
                                                <div>
                                                    <strong>1 Table & Chairs Set</strong>
                                                    <br><small class="text-muted">Durable stone table with seating</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="feature-item d-flex align-items-center p-3" 
                                                 style="background: rgba(109,76,65,0.05); border-radius: 15px; border-left: 4px solid #8d6e63;">
                                                <i class="fas fa-users fa-lg me-3" style="color: #8d6e63;"></i>
                                                <div>
                                                    <strong>Seats up to 5 people</strong>
                                                    <br><small class="text-muted">Perfect for families and small groups</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="feature-item d-flex align-items-center p-3" 
                                                 style="background: rgba(109,76,65,0.05); border-radius: 15px; border-left: 4px solid #6d4c41;">
                                                <i class="fas fa-fire fa-lg me-3" style="color: #d32f2f;"></i>
                                                <div>
                                                    <strong>BBQ Bin Included</strong>
                                                    <br><small class="text-muted">Built-in BBQ facility for outdoor cooking</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="feature-item d-flex align-items-center p-3" 
                                                 style="background: rgba(109,76,65,0.05); border-radius: 15px; border-left: 4px solid #8d6e63;">
                                                <i class="fas fa-plug fa-lg me-3" style="color: #ff9800;"></i>
                                                <div>
                                                    <strong>Power Outlet Access</strong>
                                                    <br><small class="text-muted">Convenient plug points available</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Operating Hours -->
                                <div class="mb-4">
                                    <div class="alert alert-info border-0" 
                                         style="background: linear-gradient(135deg, rgba(33,150,243,0.1), rgba(33,150,243,0.05)); 
                                                border-radius: 15px; 
                                                border-left: 4px solid #2196f3;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock fa-lg me-3" style="color: #2196f3;"></i>
                                            <div>
                                                <strong style="color: #1976d2;">Operating Hours</strong>
                                                <br><span class="text-muted">9:00 AM - 5:00 PM Daily</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                <div class="d-grid">
                                    @auth
                                        <a href="{{ route('amenity.booking.form') }}" 
                                           class="btn btn-lg"
                                           style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                                  border: none; 
                                                  border-radius: 30px; 
                                                  color: white; 
                                                  font-weight: 600; 
                                                  padding: 15px 30px;
                                                  transition: all 0.3s ease;
                                                  box-shadow: 0 8px 25px rgba(109,76,65,0.3);"
                                           onmouseover="this.style.background='linear-gradient(135deg, #8d6e63, #6d4c41)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(109,76,65,0.4)'"
                                           onmouseout="this.style.background='linear-gradient(135deg, #6d4c41, #8d6e63)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(109,76,65,0.3)'">
                                            <i class="fas fa-calendar-plus me-2"></i>
                                            <span>Reserve Table Set Now</span>
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('customer.login') }}" 
                                           class="btn btn-lg"
                                           style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                                  border: none; 
                                                  border-radius: 30px; 
                                                  color: white; 
                                                  font-weight: 600; 
                                                  padding: 15px 30px;
                                                  transition: all 0.3s ease;
                                                  box-shadow: 0 8px 25px rgba(109,76,65,0.3);"
                                           onmouseover="this.style.background='linear-gradient(135deg, #8d6e63, #6d4c41)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(109,76,65,0.4)'"
                                           onmouseout="this.style.background='linear-gradient(135deg, #6d4c41, #8d6e63)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(109,76,65,0.3)'">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            <span>Login to Book</span>
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Custom Animations -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hero-section {
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12) !important;
}

.info-card {
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15) !important;
}

.feature-item {
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: rgba(109,76,65,0.1) !important;
    transform: translateX(5px);
}
</style>
@endsection
