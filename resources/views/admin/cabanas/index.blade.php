@extends('layouts.app')

@section('title', 'Manage Cabanas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">🏠 Manage Cabanas</h1>
                <div>
                    <a href="{{ route('admin.cabanas.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>Add New Cabana
                    </a>
                    <a href="{{ route('cabanas.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Public Page
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Cabanas Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary">{{ $cabanas->count() }}</h3>
                            <p class="text-muted mb-0">Total Cabanas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $cabanas->where('allow_overnight', true)->count() }}</h3>
                            <p class="text-muted mb-0">Overnight Available</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="text-info">{{ $cabanas->sum('bookings_count') }}</h3>
                            <p class="text-muted mb-0">Total Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning">{{ $cabanas->avg('max_pax') ?? 0 }}</h3>
                            <p class="text-muted mb-0">Avg Capacity</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabanas List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Cabanas</h5>
                </div>
                <div class="card-body">
                    @if($cabanas->count() > 0)
                        <div class="row">
                            @foreach($cabanas as $cabana)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    @if($cabana->image)
                                        <img src="{{ str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $cabana->name }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-home fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $cabana->name }}</h5>
                                        
                                        <div class="mb-2">
                                            <small class="text-muted">Capacity:</small>
                                            <span class="badge bg-info">{{ $cabana->max_pax }} pax</span>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted">Bookings:</small>
                                            <span class="badge bg-success">{{ $cabana->bookings_count ?? 0 }} total</span>
                                        </div>

                                        @if($cabana->allow_overnight)
                                            <div class="mb-2">
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-moon me-1"></i>Overnight Available
                                                </span>
                                            </div>
                                        @endif

                                        <div class="pricing mb-3">
                                            @if($cabana->price_daily)
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Daily:</small>
                                                    <strong class="text-success">RM {{ number_format($cabana->price_daily, 2) }}</strong>
                                                </div>
                                            @endif
                                            @if($cabana->price_overnight)
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-muted">Overnight:</small>
                                                    <strong class="text-primary">RM {{ number_format($cabana->price_overnight, 2) }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        @if($cabana->features)
                                            <div class="mb-3">
                                                <small class="text-muted d-block mb-1">Features:</small>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach((is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true)) ?? [] as $feature)
                                                        <span class="badge bg-light text-dark">
                                                            @switch($feature)
                                                                @case('fan')
                                                                    <i class="fas fa-fan me-1"></i>Fan
                                                                    @break
                                                                @case('plugpoint')
                                                                    <i class="fas fa-plug me-1"></i>Power
                                                                    @break
                                                                @case('river_side')
                                                                    <i class="fas fa-water me-1"></i>Riverside
                                                                    @break
                                                                @default
                                                                    {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                                            @endswitch
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-auto">
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('cabanas.show', $cabana->slug) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                                <a href="{{ route('admin.bookings.index') }}?cabana={{ $cabana->id }}" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-calendar-alt me-2"></i>View Bookings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-home fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No cabanas found</h5>
                            <p class="text-muted">Cabanas will appear here once they are added to the system.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats Table -->
            @if($cabanas->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Cabana Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cabana</th>
                                    <th>Capacity</th>
                                    <th>Daily Rate</th>
                                    <th>Overnight Rate</th>
                                    <th>Total Bookings</th>
                                    <th>Features</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cabanas as $cabana)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($cabana->image)
                                                <img src="{{ str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/app/public/' . $cabana->image) }}" 
                                                     class="rounded me-2" 
                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                     alt="{{ $cabana->name }}">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-home text-muted"></i>
                                                </div>
                                            @endif
                                            <strong>{{ $cabana->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $cabana->max_pax }} pax</span>
                                    </td>
                                    <td>
                                        @if($cabana->price_daily)
                                            <span class="text-success fw-semibold">RM {{ number_format($cabana->price_daily, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($cabana->price_overnight)
                                            <span class="text-primary fw-semibold">RM {{ number_format($cabana->price_overnight, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $cabana->bookings_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($cabana->features)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach(array_slice((is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true)) ?? [], 0, 3) as $feature)
                                                    <span class="badge bg-light text-dark small">
                                                        @switch($feature)
                                                            @case('fan')
                                                                <i class="fas fa-fan"></i>
                                                                @break
                                                            @case('plugpoint')
                                                                <i class="fas fa-plug"></i>
                                                                @break
                                                            @case('river_side')
                                                                <i class="fas fa-water"></i>
                                                                @break
                                                            @default
                                                                {{ ucfirst($feature) }}
                                                        @endswitch
                                                    </span>
                                                @endforeach
                                                @php
                                                    $features = is_array($cabana->features) ? $cabana->features : json_decode($cabana->features, true) ?? [];
                                                @endphp
                                                @if(count($features) > 3)
                                                    <span class="badge bg-secondary small">+{{ count($features) - 3 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.cabanas.show', $cabana) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cabanas.edit', $cabana) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit Cabana">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Cabana"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $cabana->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
@foreach($cabanas as $cabana)
<div class="modal fade" id="deleteModal{{ $cabana->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Cabana</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $cabana->name }}</strong>?</p>
                @if($cabana->bookings_count > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This cabana has {{ $cabana->bookings_count }} booking(s). You cannot delete it until all bookings are cancelled or completed.
                    </div>
                @else
                    <p class="text-muted">This action cannot be undone.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                @if($cabana->bookings_count == 0)
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
@endforeach
@endsection
