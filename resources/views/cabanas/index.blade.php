@extends('layouts.app')

@section('content')
<!-- Custom Styles for Enhanced Design -->
<style>
    .cabana-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }
    
    .cabana-card:hover {
        transform: translateY(-15px) scale(1.02);
    }
    
    .feature-badge {
        transition: all 0.3s ease;
    }
    
    .feature-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .price-badge {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .btn-book {
        position: relative;
        overflow: hidden;
    }
    
    .btn-book::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-book:hover::before {
        left: 100%;
    }
</style>

<div class="container py-5">
    <!-- Enhanced Page Header -->
    <div class="text-center mb-5">
        <div class="d-inline-block position-relative">
            <h1 class="display-4 mb-3" style="color:#4e342e; font-family:'Playfair Display', serif; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                🏡 Our Premium Cabanas & Chalets
            </h1>
            <div class="mx-auto" style="width: 100px; height: 4px; background: linear-gradient(90deg, #6d4c41, #8d6e63, #6d4c41); border-radius: 2px;"></div>
        </div>
        <p class="lead text-muted mt-3 mb-4" style="max-width: 600px; margin: 0 auto;">
            Discover our collection of beautiful riverside accommodations, each offering unique experiences and modern amenities for your perfect getaway.
        </p>
    </div>
    
    <div class="row g-4">
    @foreach($cabanas as $cabana)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 border-0 position-relative cabana-card" style="border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); background: linear-gradient(145deg, #ffffff, #f8f9fa);">
                    
                    <!-- Enhanced Image Display with Gradient Overlay -->
                    <div class="position-relative" style="height: 280px; overflow: hidden;">
                        <img src="{{ $cabana->image ? (str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/'.$cabana->image)) : 'https://via.placeholder.com/400x280?text=No+Image' }}" 
                             class="card-img-top h-100 w-100" 
                             alt="{{ $cabana->name }}" 
                             style="object-fit: cover; transition: transform 0.5s ease; filter: brightness(0.9);">
                        
                        <!-- Gradient Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" 
                             style="background: linear-gradient(135deg, rgba(110,76,65,0.3) 0%, rgba(78,52,46,0.1) 100%);"></div>
                        
                        <!-- Floating Price Badge -->
                        <div class="position-absolute top-0 end-0 m-3">
                            <div class="badge px-3 py-2 price-badge" 
                                 style="background: linear-gradient(135deg, #28a745, #20c997); 
                                        border-radius: 25px; 
                                        font-size: 0.9rem; 
                                        font-weight: 600; 
                                        box-shadow: 0 4px 15px rgba(40,167,69,0.3);
                                        border: 2px solid rgba(255,255,255,0.2);">
                                <i class="fas fa-tag me-1"></i>RM {{ number_format($cabana->price_daily, 2) }}/day
                            </div>
                        </div>

                        <!-- Capacity Badge -->
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <div class="badge px-3 py-2" 
                                 style="background: rgba(255,255,255,0.9); 
                                        color: #4e342e; 
                                        border-radius: 20px; 
                                        font-weight: 600;
                                        backdrop-filter: blur(10px);">
                                <i class="fas fa-users me-1"></i>{{ $cabana->max_pax }} guests
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Card Body -->
                    <div class="card-body p-4" style="background: linear-gradient(145deg, #ffffff, #fafbfc);">
                        <!-- Title with Decorative Line -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0" style="color:#4e342e; font-weight: 700; font-size: 1.3rem;">
                                    {{ $cabana->name }}
                                </h5>
                                <div class="mt-1" style="width: 40px; height: 3px; background: linear-gradient(90deg, #6d4c41, #8d6e63); border-radius: 2px;"></div>
                            </div>
                            @if($cabana->allow_overnight)
                                <div class="text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-moon text-warning"></i> Overnight Available
                                    </small>
                                </div>
                            @endif
                        </div>

                        <!-- Enhanced Features Section -->
                        @if($cabana->features)
                            <div class="mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($cabana->features as $feature)
                                        <span class="badge feature-badge" 
                                              style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); 
                                                     color: #6d4c41; 
                                                     border: 1px solid #dee2e6; 
                                                     border-radius: 15px; 
                                                     padding: 6px 12px; 
                                                     font-weight: 500;
                                                     font-size: 0.75rem;
                                                     text-transform: capitalize;
                                                     box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        @php
                            $icons = [
                                'bbq_bin' => 'fas fa-fire',
                                'fan' => 'fas fa-fan',
                                'plugpoint' => 'fas fa-plug',
                                'sink' => 'fas fa-faucet',
                                'river_side' => 'fas fa-water',
                                'riverside' => 'fas fa-water',
                                'mountain_view' => 'fas fa-mountain',
                                'shared_toilet' => 'fas fa-restroom'
                            ];
                            $icon = $icons[$feature] ?? 'fas fa-check';
                        @endphp
                                            <i class="{{ $icon }} me-1" style="font-size: 0.7rem;"></i>
                                            {{ str_replace('_', ' ', $feature) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Enhanced Description -->
                        @if($cabana->description)
                            <div class="mb-4">
                                <p class="card-text" style="color: #6c757d; line-height: 1.6; font-size: 0.9rem;">
                                    {{ Str::limit($cabana->description, 120) }}
                                </p>
                            </div>
                        @endif
                        
                        <!-- Enhanced Action Button -->
                        <div class="d-grid">
                            <a href="{{ route('cabanas.show', $cabana->slug) }}" 
                               class="btn btn-lg btn-book"
                               style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                      border: none; 
                                      border-radius: 30px; 
                                      font-weight: 600; 
                                      padding: 12px 24px;
                                      transition: all 0.3s ease;
                                      box-shadow: 0 8px 25px rgba(109,76,65,0.3);"
                               onmouseover="this.style.background='linear-gradient(135deg, #8d6e63, #6d4c41)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 35px rgba(109,76,65,0.4)'"
                               onmouseout="this.style.background='linear-gradient(135deg, #6d4c41, #8d6e63)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(109,76,65,0.3)'">
                                <i class="fas fa-calendar-check me-2"></i>
                                <span>View Details & Book Now</span>
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>

                        <!-- Overnight Pricing (if available) -->
                        @if($cabana->allow_overnight && $cabana->price_overnight)
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-moon me-1"></i>
                                    Overnight: <strong>RM {{ number_format($cabana->price_overnight, 2) }}</strong>
                                </small>
                            </div>
                        @endif
                    </div>

                    <!-- Decorative Corner Element -->
                    <div class="position-absolute top-0 start-0" 
                         style="width: 0; height: 0; 
                                border-left: 30px solid #6d4c41; 
                                border-bottom: 30px solid transparent; 
                                opacity: 0.1;"></div>
                </div>
            </div>
        @endforeach
    </div>

    @if($cabanas->isEmpty())
        <div class="text-center py-5">
            <h3 class="text-muted">No cabanas available at the moment</h3>
            <p class="text-muted">Please check back later for available accommodations.</p>
        </div>
    @endif
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
