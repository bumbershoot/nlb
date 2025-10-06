@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Cabana Image -->
        <div class="col-lg-7 mb-4">
            <img src="{{ $cabana->image ? (str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/'.$cabana->image)) : 'https://via.placeholder.com/600x400' }}" 
                 class="img-fluid rounded shadow-lg" 
                 alt="{{ $cabana->name }}"
                 style="width: 100%; height: 400px; object-fit: cover;">
        </div>
        
        <!-- Cabana Details & Booking Form -->
        <div class="col-lg-5">
            <!-- Cabana Information -->
            <div class="mb-4">
                <h1 class="display-5 fw-bold text-brown mb-3">{{ $cabana->name }}</h1>
                <p class="text-muted fs-5 mb-3">{{ $cabana->description }}</p>
                <div class="d-flex align-items-center mb-4">
                    <h3 class="text-primary fw-bold mb-0">RM {{ number_format($cabana->price_daily, 2) }}</h3>
                    <span class="text-muted ms-2">/ day</span>
                </div>
            </div>

            <!-- Booking Form -->
            @auth
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="cabana_id" value="{{ $cabana->id }}">
                        
                        <!-- Check-in Date -->
                        <div class="mb-3">
                            <label for="check_in" class="form-label fw-semibold text-dark">Check-in</label>
                            <input type="date" 
                                   name="check_in" 
                                   id="check_in" 
                                   class="form-control form-control-lg" 
                                   style="border-radius: 10px; border: 2px solid #e9ecef;"
                                   required
                                   min="{{ date('Y-m-d') }}">
                        </div>
                        
                        <!-- Check-out Date -->
                        <div class="mb-3">
                            <label for="check_out" class="form-label fw-semibold text-dark">Check-out</label>
                            <input type="date" 
                                   name="check_out" 
                                   id="check_out" 
                                   class="form-control form-control-lg" 
                                   style="border-radius: 10px; border: 2px solid #e9ecef;"
                                   required>
                        </div>
                        
                        <!-- Check-in and Check-out Times -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="check_in_time" class="form-label fw-semibold text-dark">Check-in Time</label>
                                <select name="check_in_time" id="check_in_time" class="form-select form-select-lg" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    <option value="15:00">3:00 PM (Standard)</option>
                                    <option value="14:00">2:00 PM (Early)</option>
                                    <option value="16:00">4:00 PM (Late)</option>
                                    <option value="17:00">5:00 PM (Very Late)</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="check_out_time" class="form-label fw-semibold text-dark">Check-out Time</label>
                                <select name="check_out_time" id="check_out_time" class="form-select form-select-lg" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    <option value="11:00">11:00 AM (Standard)</option>
                                    <option value="10:00">10:00 AM (Early)</option>
                                    <option value="12:00">12:00 PM (Late)</option>
                                    <option value="13:00">1:00 PM (Very Late)</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Guest Details -->
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="adults" class="form-label fw-semibold text-dark">Adults</label>
                                    <select name="pax" id="adults" class="form-select form-select-lg" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kids" class="form-label fw-semibold text-dark">Kids</label>
                                    <select name="kids" id="kids" class="form-select form-select-lg" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Information -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control form-control-lg" 
                                   style="border-radius: 10px; border: 2px solid #e9ecef;"
                                   placeholder="Enter your full name"
                                   value="{{ auth()->user()->name }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-dark">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control form-control-lg" 
                                   style="border-radius: 10px; border: 2px solid #e9ecef;"
                                   placeholder="Enter your email"
                                   value="{{ auth()->user()->email }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label fw-semibold text-dark">Phone Number</label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   class="form-control form-control-lg" 
                                   style="border-radius: 10px; border: 2px solid #e9ecef;"
                                   placeholder="Enter your phone number"
                                   required>
                        </div>
                        
                        <!-- Price Calculation -->
                        <div class="mb-4 p-3 bg-light rounded" style="border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Total Amount:</span>
                                <span class="h4 fw-bold text-primary mb-0" id="totalAmount">RM 0.00</span>
                            </div>
                            <small class="text-muted" id="nightsInfo">Select dates to calculate price</small>
                        </div>
                        
                        <!-- Book Now Button -->
                        <button type="submit" 
                                class="btn btn-lg w-100 fw-bold" 
                                style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                       border: none; 
                                       border-radius: 15px; 
                                       padding: 15px;
                                       color: white;
                                       font-size: 1.1rem;
                                       transition: all 0.3s ease;">
                            <i class="fas fa-calendar-check me-2"></i>Book Now
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Login Prompt for Guests -->
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-user-lock fa-3x text-muted mb-3"></i>
                    <h5 class="mb-3">Login Required</h5>
                    <p class="text-muted mb-4">Please login or create an account to make a booking.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </a>
                    </div>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInDate = document.getElementById('check_in');
    const checkOutDate = document.getElementById('check_out');
    const totalAmount = document.getElementById('totalAmount');
    const nightsInfo = document.getElementById('nightsInfo');
    const dailyRate = {{ $cabana->price_daily }};

    function calculateTotal() {
        if (checkInDate.value && checkOutDate.value) {
            const checkIn = new Date(checkInDate.value);
            const checkOut = new Date(checkOutDate.value);
            const timeDiff = checkOut.getTime() - checkIn.getTime();
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            if (nights > 0) {
                const total = nights * dailyRate;
                totalAmount.textContent = 'RM ' + total.toLocaleString('en-MY', {minimumFractionDigits: 2});
                nightsInfo.textContent = nights + (nights === 1 ? ' night' : ' nights');
            } else {
                totalAmount.textContent = 'RM 0.00';
                nightsInfo.textContent = 'Invalid date range';
            }
        }
    }

    // Set minimum check-out date when check-in changes
    checkInDate.addEventListener('change', function() {
        const nextDay = new Date(this.value);
        nextDay.setDate(nextDay.getDate() + 1);
        checkOutDate.min = nextDay.toISOString().split('T')[0];
        calculateTotal();
    });

    checkOutDate.addEventListener('change', calculateTotal);
});
</script>

<style>
.text-brown {
    color: #6d4c41;
}

.form-control:focus, .form-select:focus {
    border-color: #6d4c41;
    box-shadow: 0 0 0 0.2rem rgba(109, 76, 65, 0.25);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(109, 76, 65, 0.3);
}
</style>
@endsection
