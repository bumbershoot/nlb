@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #6d4c41, #8d6e63); color: white;">
                    <h2 class="mb-0"><i class="fas fa-utensils me-2"></i>Amenity Booking Form</h2>
                    <p class="mb-0 mt-2">Please fill out the form below to book your amenity</p>
                </div>
                
                <div class="card-body p-5">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <!-- Amenity Selection -->
                        <div class="mb-4">
                            <label for="amenity" class="form-label fw-semibold text-dark">Select Amenity</label>
                            <select class="form-select form-select-lg" id="amenity" name="amenity_id" 
                                    style="border-radius: 10px; border: 2px solid #e9ecef;" required>
                                @foreach ($amenities as $amenity)
                                    <option value="{{ $amenity->id }}" data-price="{{ $amenity->price_per_booking }}" data-max-pax="{{ $amenity->max_pax }}">
                                        {{ $amenity->name }} (RM {{ $amenity->price_per_booking }}) - Max {{ $amenity->max_pax }} pax
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Check-in Date -->
                        <div class="mb-3">
                            <label for="check_in" class="form-label fw-semibold text-dark">Check-in Date</label>
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
                            <label for="check_out" class="form-label fw-semibold text-dark">Check-out Date</label>
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
                                    <option value="09:00">9:00 AM (Standard)</option>
                                    <option value="10:00">10:00 AM (Early)</option>
                                    <option value="11:00">11:00 AM (Late)</option>
                                    <option value="12:00">12:00 PM (Very Late)</option>
                                    <option value="13:00">1:00 PM (Afternoon)</option>
                                    <option value="14:00">2:00 PM (Afternoon)</option>
                                    <option value="15:00">3:00 PM (Afternoon)</option>
                                    <option value="16:00">4:00 PM (Late Afternoon)</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="check_out_time" class="form-label fw-semibold text-dark">Check-out Time</label>
                                <select name="check_out_time" id="check_out_time" class="form-select form-select-lg" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                    <option value="11:00">11:00 AM (Standard)</option>
                                    <option value="12:00">12:00 PM (Late)</option>
                                    <option value="13:00">1:00 PM (Very Late)</option>
                                    <option value="14:00">2:00 PM (Afternoon)</option>
                                    <option value="15:00">3:00 PM (Afternoon)</option>
                                    <option value="16:00">4:00 PM (Late Afternoon)</option>
                                    <option value="17:00">5:00 PM (Closing Time)</option>
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
                                   value="{{ auth()->user()->name ?? '' }}"
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
                                   value="{{ auth()->user()->email ?? '' }}"
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
                                <span class="fw-bold text-success fs-5">RM <span id="total_price">0</span></span>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" 
                                    style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                           border: none; 
                                           border-radius: 30px; 
                                           color: white; 
                                           font-weight: 600; 
                                           padding: 15px 30px;
                                           transition: all 0.3s ease;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #8d6e63, #6d4c41)'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #6d4c41, #8d6e63)'">
                                <i class="fas fa-calendar-plus me-2"></i>Book Amenity Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amenitySelect = document.getElementById('amenity');
    const totalPriceSpan = document.getElementById('total_price');
    const adultsSelect = document.getElementById('adults');
    const kidsSelect = document.getElementById('kids');
    const checkInDate = document.getElementById('check_in');
    const checkOutDate = document.getElementById('check_out');

    function updatePrice() {
        const selectedOption = amenitySelect.options[amenitySelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const maxPax = selectedOption.getAttribute('data-max-pax');
        
        // Calculate total guests
        const adults = parseInt(adultsSelect.value);
        const kids = parseInt(kidsSelect.value);
        const totalGuests = adults + kids;
        
        // Update max pax validation
        adultsSelect.setAttribute('data-max', maxPax);
        
        // Calculate price based on duration and guests
        const checkIn = new Date(checkInDate.value);
        const checkOut = new Date(checkOutDate.value);
        let totalPrice = parseFloat(price);
        
        if (checkIn && checkOut && checkOut > checkIn) {
            const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            totalPrice = totalPrice * days;
        }
        
        totalPriceSpan.textContent = totalPrice.toFixed(2);
    }

    function updateGuestValidation() {
        const selectedOption = amenitySelect.options[amenitySelect.selectedIndex];
        const maxPax = parseInt(selectedOption.getAttribute('data-max-pax'));
        
        // Update adults options based on max pax
        const adultsOptions = adultsSelect.querySelectorAll('option');
        adultsOptions.forEach(option => {
            const value = parseInt(option.value);
            if (value > maxPax) {
                option.style.display = 'none';
            } else {
                option.style.display = 'block';
            }
        });
        
        // Ensure current selection is valid
        const currentAdults = parseInt(adultsSelect.value);
        if (currentAdults > maxPax) {
            adultsSelect.value = maxPax;
        }
    }

    amenitySelect.addEventListener('change', function() {
        updatePrice();
        updateGuestValidation();
    });
    
    adultsSelect.addEventListener('change', updatePrice);
    kidsSelect.addEventListener('change', updatePrice);
    checkInDate.addEventListener('change', updatePrice);
    checkOutDate.addEventListener('change', updatePrice);
    
    // Initial call
    updatePrice();
    updateGuestValidation();
});
</script>
@endsection
