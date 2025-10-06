@extends('layouts.app')

@section('title', 'Cabana Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">🏠 {{ $cabana->name }}</h1>
                <div>
                    <a href="{{ route('admin.cabanas.edit', $cabana) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit Cabana
                    </a>
                    <a href="{{ route('admin.cabanas.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Cabanas
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Cabana Image -->
                    <div class="card mb-4">
                        <div class="card-body">
                            @if($cabana->image)
                                <img src="{{ str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image) }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px; width: 100%; object-fit: cover;"
                                     alt="{{ $cabana->name }}">
                            @else
                                <div class="text-center py-5 bg-light rounded">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No image available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cabana Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Cabana Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Name</h6>
                                    <p class="fw-semibold">{{ $cabana->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Slug</h6>
                                    <p class="fw-semibold">{{ $cabana->slug }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Maximum Capacity</h6>
                                    <p class="fw-semibold">{{ $cabana->max_pax }} pax</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Overnight Stays</h6>
                                    <p class="fw-semibold">
                                        @if($cabana->allow_overnight)
                                            <span class="badge bg-success">Allowed</span>
                                        @else
                                            <span class="badge bg-secondary">Not Allowed</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-muted">Description</h6>
                                    <p class="fw-semibold">{{ $cabana->description ?: 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Daily Price</h6>
                                    <p class="fw-semibold text-success fs-4">RM {{ number_format($cabana->price_daily, 2) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Overnight Price</h6>
                                    <p class="fw-semibold text-primary fs-4">
                                        {{ $cabana->price_overnight ? 'RM ' . number_format($cabana->price_overnight, 2) : 'Not set' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    @if($cabana->features)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Features</h5>
                            </div>
                            <div class="card-body">
                                @php
                                    $features = is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true) ?? [];
                                @endphp
                                @if(count($features) > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($features as $feature)
                                            <span class="badge bg-primary">
                                                @switch($feature)
                                                    @case('fan')
                                                        <i class="fas fa-fan me-1"></i>Fan
                                                        @break
                                                    @case('plugpoint')
                                                        <i class="fas fa-plug me-1"></i>Power Outlet
                                                        @break
                                                    @case('river_side')
                                                        <i class="fas fa-water me-1"></i>River Side
                                                        @break
                                                    @case('air_conditioning')
                                                        <i class="fas fa-snowflake me-1"></i>Air Conditioning
                                                        @break
                                                    @case('wifi')
                                                        <i class="fas fa-wifi me-1"></i>WiFi
                                                        @break
                                                    @case('parking')
                                                        <i class="fas fa-car me-1"></i>Parking
                                                        @break
                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                                @endswitch
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No features specified</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">📊 Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 class="text-primary">{{ $cabana->bookings_count ?? 0 }}</h4>
                                    <small class="text-muted">Total Bookings</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success">{{ $cabana->max_pax }}</h4>
                                    <small class="text-muted">Max Capacity</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">⚡ Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.cabanas.edit', $cabana) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Cabana
                                </a>
                                <a href="{{ route('cabanas.show', $cabana->slug) }}" class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>View Public Page
                                </a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-2"></i>Delete Cabana
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">📅 Recent Bookings</h6>
                        </div>
                        <div class="card-body">
                            @if($cabana->bookings && $cabana->bookings->count() > 0)
                                @foreach($cabana->bookings->take(5) as $booking)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <small class="fw-semibold">#{{ $booking->id }}</small>
                                            <br>
                                            <small class="text-muted">{{ $booking->date_from }} - {{ $booking->date_to }}</small>
                                        </div>
                                        <span class="badge 
                                            @if($booking->status == 'confirmed') bg-success
                                            @elseif($booking->status == 'pending') bg-warning
                                            @elseif($booking->status == 'cancelled') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center">No bookings yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Cabana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $cabana->name }}</strong>?</p>
                @if($cabana->bookings && $cabana->bookings->count() > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This cabana has {{ $cabana->bookings->count() }} booking(s). You cannot delete it until all bookings are cancelled or completed.
                    </div>
                @else
                    <p class="text-muted">This action cannot be undone.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                @if($cabana->bookings && $cabana->bookings->count() == 0)
                    <form action="{{ route('admin.cabanas.destroy', $cabana) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Cabana</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
