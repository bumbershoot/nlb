@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="color: #6d4c41;">
                    <i class="fas fa-utensils me-3"></i>Resort Amenities
                </h2>
                <p class="lead text-muted">Enhance your stay with our premium amenities</p>
                <div class="decoration-line mx-auto" 
                     style="width: 80px; height: 3px; background: linear-gradient(90deg, #6d4c41, #8d6e63); border-radius: 2px;"></div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        @forelse($amenities as $amenity)
            <div class="col-lg-8 col-xl-6 mb-4">
                <div class="card border-0 shadow-lg h-100" 
                     style="border-radius: 25px; overflow: hidden; background: linear-gradient(145deg, #ffffff, #fafbfc);">
                    <div class="row g-0 h-100">
                        <!-- Image Section -->
                        <div class="col-md-5">
                            <div class="image-container h-100 position-relative d-flex align-items-center justify-content-center" 
                                 style="min-height: 300px; overflow: hidden; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                                @if($amenity->image)
                                    <img src="{{ asset($amenity->image) }}" 
                                         alt="{{ $amenity->name }}" 
                                         class="img-fluid rounded shadow"
                                         style="max-width: 100%; max-height: 250px; object-fit: cover; width: 100%; height: 250px;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="text-center" style="display: none;">
                                        <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
                                        <p class="text-muted">{{ $amenity->name }}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
                                        <p class="text-muted">{{ $amenity->name }}</p>
                                    </div>
                                @endif
                                <!-- Image overlay -->
                                <div class="position-absolute top-0 start-0 w-100 h-100" 
                                     style="background: linear-gradient(135deg, rgba(109,76,65,0.05), rgba(141,110,99,0.05)); pointer-events: none;"></div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="col-md-7">
                            <div class="card-body p-4 h-100 d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <h3 class="card-title fw-bold mb-2" style="color: #4e342e; font-size: 1.5rem;">
                                        {{ $amenity->name }}
                                    </h3>
                                    <h4 class="text-success fw-bold mb-3" style="font-size: 1.3rem;">
                                        <i class="fas fa-tag me-2"></i>RM {{ number_format($amenity->price_per_booking, 2) }} 
                                        <small class="text-muted fw-normal">per booking</small>
                                    </h4>
                                </div>

                                <!-- Description -->
                                <p class="text-muted mb-3">{{ Str::limit($amenity->description, 100) }}</p>

                                <!-- Features -->
                                @if($amenity->features)
                                    <div class="mb-3">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($amenity->features as $feature)
                                                <span class="badge" style="background: rgba(109,76,65,0.1); color: #6d4c41;">
                                                    {{ ucwords(str_replace('_', ' ', $feature)) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Operating Hours -->
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Operating Hours: {{ \Carbon\Carbon::parse($amenity->operating_hours_start)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($amenity->operating_hours_end)->format('H:i') }}
                                    </small>
                                </div>

                                <!-- Max Pax -->
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        Max {{ $amenity->max_pax }} people
                                    </small>
                                </div>

                                <!-- Book Now Button -->
                                <div class="d-grid">
                                    @auth
                                        <a href="{{ route('amenity.booking.form') }}" 
                                           class="btn btn-sm"
                                           style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                                  border: none; 
                                                  border-radius: 20px; 
                                                  color: white; 
                                                  font-weight: 600; 
                                                  padding: 10px 20px;
                                                  transition: all 0.3s ease;"
                                           onmouseover="this.style.background='linear-gradient(135deg, #8d6e63, #6d4c41)'"
                                           onmouseout="this.style.background='linear-gradient(135deg, #6d4c41, #8d6e63)'">
                                            <i class="fas fa-calendar-plus me-2"></i>
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('customer.login') }}" 
                                           class="btn btn-sm"
                                           style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                                  border: none; 
                                                  border-radius: 20px; 
                                                  color: white; 
                                                  font-weight: 600; 
                                                  padding: 10px 20px;
                                                  transition: all 0.3s ease;">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Login to Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No amenities available at the moment</h4>
                    <p class="text-muted">Please check back later for our exciting amenities.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12) !important;
}

.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    background: rgba(109,76,65,0.2) !important;
    transform: scale(1.05);
}
</style>
@endsection
