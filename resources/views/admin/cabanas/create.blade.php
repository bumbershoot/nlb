@extends('layouts.app')

@section('title', 'Add New Cabana')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">🏠 Add New Cabana</h1>
                <div>
                    <a href="{{ route('admin.cabanas.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Cabanas
                    </a>
                </div>
            </div>

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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cabana Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cabanas.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Basic Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Basic Information</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Cabana Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="max_pax" class="form-label">Maximum Capacity (Pax) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('max_pax') is-invalid @enderror" 
                                                   id="max_pax" name="max_pax" value="{{ old('max_pax') }}" 
                                                   min="1" max="50" required>
                                            @error('max_pax')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Pricing</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price_daily" class="form-label">Daily Price (RM) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price_daily') is-invalid @enderror" 
                                                   id="price_daily" name="price_daily" value="{{ old('price_daily') }}" 
                                                   step="0.01" min="0" required>
                                            @error('price_daily')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price_overnight" class="form-label">Overnight Price (RM)</label>
                                            <input type="number" class="form-control @error('price_overnight') is-invalid @enderror" 
                                                   id="price_overnight" name="price_overnight" value="{{ old('price_overnight') }}" 
                                                   step="0.01" min="0">
                                            @error('price_overnight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Features</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="fan" id="feature_fan">
                                                    <label class="form-check-label" for="feature_fan">
                                                        <i class="fas fa-fan me-1"></i>Fan
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="plugpoint" id="feature_plugpoint">
                                                    <label class="form-check-label" for="feature_plugpoint">
                                                        <i class="fas fa-plug me-1"></i>Power Outlet
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="river_side" id="feature_river_side">
                                                    <label class="form-check-label" for="feature_river_side">
                                                        <i class="fas fa-water me-1"></i>River Side
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="air_conditioning" id="feature_ac">
                                                    <label class="form-check-label" for="feature_ac">
                                                        <i class="fas fa-snowflake me-1"></i>Air Conditioning
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="wifi" id="feature_wifi">
                                                    <label class="form-check-label" for="feature_wifi">
                                                        <i class="fas fa-wifi me-1"></i>WiFi
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="features[]" value="parking" id="feature_parking">
                                                    <label class="form-check-label" for="feature_parking">
                                                        <i class="fas fa-car me-1"></i>Parking
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Settings</h6>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allow_overnight" id="allow_overnight" value="1">
                                            <label class="form-check-label" for="allow_overnight">
                                                Allow Overnight Stays
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Image</h6>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Cabana Image</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" name="image" accept="image/*">
                                            <div class="form-text">Upload a high-quality image of the cabana (max 2MB)</div>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Cabana
                                    </button>
                                    <a href="{{ route('admin.cabanas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Help Panel -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">💡 Tips</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Use descriptive names for easy identification
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Set realistic capacity limits
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Upload high-quality images for better appeal
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Select relevant features for your cabana
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Enable overnight stays if applicable
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
