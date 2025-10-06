@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">👥 Manage Customers</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Customers List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Customers</h5>
                </div>
                <div class="card-body">
                    @if(isset($customers) && $customers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Total Bookings</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $customer->name }}</div>
                                                    <small class="text-muted">Customer ID: #{{ $customer->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $customer->bookings_count ?? 0 }} bookings</span>
                                        </td>
                                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.bookings.index') }}?customer={{ $customer->id }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-calendar-alt me-1"></i>View Bookings
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($customers, 'links'))
                            <div class="mt-3">
                                {{ $customers->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No customers found</h5>
                            <p class="text-muted">Customers will appear here when they register and make bookings.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.875rem;
}
</style>
@endsection
