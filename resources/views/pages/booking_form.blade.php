@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Booking Form</h2>
    <p>Please fill out the form below to book your cabana:</p>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <!-- Full Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Cabana Selection -->
        <div class="mb-3">
            <label for="cabana" class="form-label">Select Cabana</label>
            <select class="form-select" id="cabana" name="cabana_id" required>
                @foreach ($cabanas as $cabana)
                    <option value="{{ $cabana->id }}">{{ $cabana->name }} (RM {{ $cabana->price_daily }})</option>
                @endforeach
            </select>
        </div>

        <!-- Check-in Date -->
        <div class="mb-3">
            <label for="check_in" class="form-label">Check-in Date</label>
            <input type="date" class="form-control" id="check_in" name="check_in" required>
        </div>

        <!-- Check-out Date -->
        <div class="mb-3">
            <label for="check_out" class="form-label">Check-out Date</label>
            <input type="date" class="form-control" id="check_out" name="check_out" required>
        </div>

        <!-- Number of Pax -->
        <div class="mb-3">
            <label for="pax" class="form-label">Number of Guests (Pax)</label>
            <input type="number" class="form-control" id="pax" name="pax" min="1" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>
@endsection
