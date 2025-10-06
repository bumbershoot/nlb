@extends('layouts.app')

@section('title', 'Payment Management')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">💳 Payment Management</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Payments List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Payments</h5>
                </div>
                <div class="card-body">
                    @if(isset($payments) && $payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Cabana</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Reference</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($payment->booking->user->name ?? $payment->booking->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $payment->booking->user->name ?? $payment->booking->name }}</div>
                                                    <small class="text-muted">{{ $payment->booking->user->email ?? $payment->booking->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $payment->booking->cabana->name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                @switch($payment->method)
                                                    @case('toyyibpay')
                                                        <i class="fas fa-credit-card me-1"></i>ToyyibPay
                                                        @break
                                                    @case('fpx')
                                                        <i class="fas fa-university me-1"></i>FPX
                                                        @break
                                                    @case('bank_transfer')
                                                        <i class="fas fa-exchange-alt me-1"></i>Bank Transfer
                                                        @break
                                                    @case('cash')
                                                        <i class="fas fa-money-bill me-1"></i>Cash
                                                        @break
                                                    @default
                                                        {{ ucfirst($payment->method) }}
                                                @endswitch
                                            </span>
                                        </td>
                                        <td class="fw-semibold">RM {{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $payment->status === 'paid' ? 'success' : 
                                                ($payment->status === 'pending' ? 'warning' : 'danger') 
                                            }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($payment->reference)
                                                <code class="small">{{ $payment->reference }}</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($payments, 'links'))
                            <div class="mt-3">
                                {{ $payments->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No payments found</h5>
                            <p class="text-muted">Payment records will appear here when customers make payments.</p>
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
    
    /* Fix pagination arrow styling */
    .pagination .page-link {
        font-size: 0.875rem !important;
        padding: 0.375rem 0.75rem !important;
    }
    
    .pagination .page-link:focus {
        border-color: #6c757d !important;
        box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25) !important;
    }
    
    /* Remove blue focus styling from pagination */
    .pagination .page-link:focus,
    .pagination .page-link:hover {
        color: #6c757d !important;
        background-color: #fff !important;
        border-color: #dee2e6 !important;
    }
    
    /* Completely hide pagination arrows */
    .pagination .page-link[rel="prev"],
    .pagination .page-link[rel="next"],
    .pagination .page-link[aria-label*="Previous"],
    .pagination .page-link[aria-label*="Next"] {
        display: none !important;
    }
    
    /* Hide any remaining arrow symbols */
    .pagination .page-link::before,
    .pagination .page-link::after {
        content: none !important;
    }
</style>

@endsection
