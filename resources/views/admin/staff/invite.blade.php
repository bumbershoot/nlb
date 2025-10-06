@extends('layouts.app')

@section('title', 'Invite Staff')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Invite New Staff Member
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.staff.send-invitation') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       placeholder="Enter staff member's full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       placeholder="Enter staff member's email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="admin_role" class="form-label">Staff Role *</label>
                            <select name="admin_role" id="admin_role" class="form-select @error('admin_role') is-invalid @enderror" required>
                                <option value="">Select a role...</option>
                                @if(Auth::user()->isSuperAdmin())
                                <option value="manager" {{ old('admin_role') === 'manager' ? 'selected' : '' }}>
                                    Manager - Full access except super admin functions
                                </option>
                                @endif
                                <option value="staff" {{ old('admin_role') === 'staff' ? 'selected' : '' }}>
                                    Staff - Daily operations and booking management
                                </option>
                                <option value="read_only" {{ old('admin_role') === 'read_only' ? 'selected' : '' }}>
                                    Read Only - View access only, no modifications
                                </option>
                            </select>
                            @error('admin_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role Descriptions -->
                        <div class="mb-4">
                            <h6 class="text-muted">Role Permissions:</h6>
                            <div class="row">
                                @if(Auth::user()->isSuperAdmin())
                                <div class="col-md-4">
                                    <div class="card border-warning">
                                        <div class="card-body p-3">
                                            <h6 class="text-warning mb-2">👨‍💼 Manager</h6>
                                            <ul class="small text-muted mb-0">
                                                <li>View all bookings</li>
                                                <li>Manage customers</li>
                                                <li>Handle payments</li>
                                                <li>Generate reports</li>
                                                <li>Manage staff (limited)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="card border-info">
                                        <div class="card-body p-3">
                                            <h6 class="text-info mb-2">👤 Staff</h6>
                                            <ul class="small text-muted mb-0">
                                                <li>View bookings</li>
                                                <li>Update booking status</li>
                                                <li>Check-in/out guests</li>
                                                <li>View customer info</li>
                                                <li>Basic payment handling</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-secondary">
                                        <div class="card-body p-3">
                                            <h6 class="text-secondary mb-2">👁️ Read Only</h6>
                                            <ul class="small text-muted mb-0">
                                                <li>View bookings (read-only)</li>
                                                <li>View customer info</li>
                                                <li>Check schedules</li>
                                                <li>No modifications allowed</li>
                                                <li>Perfect for housekeeping</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Staff List
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Send Invitation
                            </button>
                        </div>
                    </form>

                    <!-- Information Box -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-info-circle me-2"></i>How it works:
                        </h6>
                        <ol class="small text-muted mb-0">
                            <li>Enter the staff member's details and select their role</li>
                            <li>An invitation will be created in the system</li>
                            <li>Share the registration link with the staff member</li>
                            <li>They can complete their registration using the invitation token</li>
                            <li>Once registered, they'll have access based on their assigned role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
