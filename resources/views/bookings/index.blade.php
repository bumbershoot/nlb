@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>My Bookings</h4>
                    <div class="btn-group">
                        <a href="{{ route('booking.form') }}" class="btn btn-primary">
                            <i class="fas fa-bed me-2"></i>Book Cabana
                        </a>
                        <a href="{{ route('amenity.booking.form') }}" class="btn btn-success">
                            <i class="fas fa-utensils me-2"></i>Book Amenity
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($bookings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No bookings found</h5>
                            <p class="text-muted">You haven't made any bookings yet.</p>
                            <div class="btn-group">
                                <a href="{{ route('cabanas.index') }}" class="btn btn-primary">
                                    <i class="fas fa-bed me-2"></i>Browse Cabanas
                                </a>
                                <a href="{{ route('amenities.index') }}" class="btn btn-success">
                                    <i class="fas fa-utensils me-2"></i>Browse Amenities
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Booking #</th>
                                        <th>Type</th>
                                        <th>Item</th>
                                        <th>Date/Check-in</th>
                                        <th>Time/Check-out</th>
                                        <th>Guests</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>#{{ $booking->id }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $booking->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                @if($booking->booking_type === 'cabana')
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-bed me-1"></i>Cabana
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-utensils me-1"></i>Amenity
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($booking->cabana)
                                                        @if($booking->cabana->image)
                                                            <img src="{{ str_starts_with($booking->cabana->image, 'images/') ? asset($booking->cabana->image) : asset('storage/' . $booking->cabana->image) }}" 
                                                                 alt="{{ $booking->cabana->name }}" 
                                                                 class="rounded me-2"
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $booking->cabana->name }}</strong>
                                                        </div>
                                                    @elseif($booking->amenity)
                                                        @if($booking->amenity->image)
                                                            <img src="{{ asset($booking->amenity->image) }}" 
                                                                 alt="{{ $booking->amenity->name }}" 
                                                                 class="rounded me-2"
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $booking->amenity->name }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar-alt text-success me-1"></i>
                                                {{ \Carbon\Carbon::parse($booking->date_from)->format('d M Y') }}
                                            </td>
                                            <td>
                                                @if($booking->booking_type === 'cabana')
                                                    <i class="fas fa-calendar-alt text-danger me-1"></i>
                                                    {{ \Carbon\Carbon::parse($booking->date_to)->format('d M Y') }}
                                                @else
                                                    <i class="fas fa-clock text-info me-1"></i>
                                                    {{ \Carbon\Carbon::parse($booking->check_in_time)->format('H:i') }}
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-users me-1"></i>
                                                {{ $booking->pax }}
                                            </td>
                                            <td>
                                                <strong>RM {{ number_format($booking->total_price, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if($booking->status === 'pending')
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-clock me-1"></i>Pending Payment
                                                    </span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>Confirmed
                                                    </span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle me-1"></i>Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('bookings.show', $booking->id) }}" 
                                                       class="btn btn-outline-primary" 
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    @if($booking->status === 'pending')
                                                        <a href="{{ route('bookings.show', $booking->id) }}" 
                                                           class="btn btn-outline-success" 
                                                           title="Complete Payment">
                                                            <i class="fas fa-credit-card"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($booking->payment && $booking->payment->status === 'paid')
                                                        <button class="btn btn-outline-info" 
                                                                title="Download Receipt" 
                                                                onclick="downloadReceipt({{ $booking->id }})">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($bookings->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bookings->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Booking Summary Cards -->
            @if(!$bookings->isEmpty())
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                <h5>{{ $bookings->where('status', 'confirmed')->count() }}</h5>
                                <p class="text-muted mb-0">Confirmed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                <h5>{{ $bookings->where('status', 'pending')->count() }}</h5>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <h5>RM {{ number_format($bookings->sum('total_price'), 2) }}</h5>
                                <p class="text-muted mb-0">Total Spent</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-bed fa-2x text-info mb-2"></i>
                                <h5>{{ $bookings->sum(function($booking) { return \Carbon\Carbon::parse($booking->date_from)->diffInDays(\Carbon\Carbon::parse($booking->date_to)); }) }}</h5>
                                <p class="text-muted mb-0">Total Nights</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function downloadReceipt(bookingId) {
    // Implement receipt download functionality
    alert('Receipt download feature coming soon!');
}
</script>
@endsection
