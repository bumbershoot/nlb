@extends('layouts.app')

@section('title', 'E-Invoice Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">E-Invoice Management</h3>
                    <div>
                        <button type="button" class="btn btn-primary" id="bulkSubmitBtn" disabled>
                            <i class="fas fa-upload"></i> Bulk Submit
                        </button>
                        <button type="button" class="btn btn-info" id="refreshStatsBtn">
                            <i class="fas fa-sync"></i> Refresh Statistics
                        </button>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="card-body">
                    <div class="row mb-4" id="statisticsCards">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0" id="totalInvoices">-</h4>
                                            <p class="mb-0">Total Invoices</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-file-invoice fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0" id="pendingEinvoices">-</h4>
                                            <p class="mb-0">Pending E-Invoices</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0" id="approvedEinvoices">-</h4>
                                            <p class="mb-0">Approved E-Invoices</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="mb-0" id="rejectedEinvoices">-</h4>
                                            <p class="mb-0">Rejected E-Invoices</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoices Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="invoicesTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>E-Invoice Status</th>
                                    <th>Issue Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input invoice-checkbox" 
                                               value="{{ $invoice->id }}" 
                                               data-can-submit="{{ $invoice->canSubmitEinvoice() ? 'true' : 'false' }}">
                                    </td>
                                    <td>
                                        <strong>{{ $invoice->invoice_number }}</strong>
                                        @if($invoice->einvoice_number)
                                            <br><small class="text-muted">E-Invoice: {{ $invoice->einvoice_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $invoice->customer_name }}<br>
                                        <small class="text-muted">{{ $invoice->customer_email }}</small>
                                    </td>
                                    <td>
                                        <strong>RM {{ number_format($invoice->total_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $invoice->status_color }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($invoice->hasEinvoice())
                                            <span class="badge bg-{{ $invoice->einvoice_status_color }}">
                                                {{ ucfirst($invoice->einvoice_status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Not Submitted</span>
                                        @endif
                                    </td>
                                    <td>{{ $invoice->issue_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($invoice->canSubmitEinvoice())
                                                <button type="button" class="btn btn-sm btn-primary submit-einvoice-btn" 
                                                        data-invoice-id="{{ $invoice->id }}">
                                                    <i class="fas fa-upload"></i> Submit
                                                </button>
                                            @endif
                                            
                                            @if($invoice->hasEinvoice())
                                                <button type="button" class="btn btn-sm btn-info check-status-btn" 
                                                        data-invoice-id="{{ $invoice->id }}">
                                                    <i class="fas fa-sync"></i> Check
                                                </button>
                                                
                                                @if($invoice->isEinvoiceApproved())
                                                    <button type="button" class="btn btn-sm btn-success generate-pdf-btn" 
                                                            data-invoice-id="{{ $invoice->id }}">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No invoices found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Processing...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Load statistics on page load
    loadStatistics();

    // Select all checkbox functionality
    $('#selectAll').change(function() {
        $('.invoice-checkbox').prop('checked', this.checked);
        updateBulkSubmitButton();
    });

    // Individual checkbox change
    $('.invoice-checkbox').change(function() {
        updateBulkSubmitButton();
    });

    // Submit individual e-invoice
    $('.submit-einvoice-btn').click(function() {
        const invoiceId = $(this).data('invoice-id');
        submitEinvoice(invoiceId);
    });

    // Check e-invoice status
    $('.check-status-btn').click(function() {
        const invoiceId = $(this).data('invoice-id');
        checkEinvoiceStatus(invoiceId);
    });

    // Generate PDF
    $('.generate-pdf-btn').click(function() {
        const invoiceId = $(this).data('invoice-id');
        generateEinvoicePDF(invoiceId);
    });

    // Bulk submit
    $('#bulkSubmitBtn').click(function() {
        const selectedInvoices = $('.invoice-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedInvoices.length > 0) {
            bulkSubmitEinvoices(selectedInvoices);
        }
    });

    // Refresh statistics
    $('#refreshStatsBtn').click(function() {
        loadStatistics();
    });

    function updateBulkSubmitButton() {
        const selectedCount = $('.invoice-checkbox:checked').length;
        $('#bulkSubmitBtn').prop('disabled', selectedCount === 0);
        $('#bulkSubmitBtn').text(`Bulk Submit (${selectedCount})`);
    }

    function loadStatistics() {
        $.get('{{ route("einvoices.statistics") }}')
            .done(function(response) {
                if (response.success) {
                    $('#totalInvoices').text(response.data.total_invoices);
                    $('#pendingEinvoices').text(response.data.einvoice_pending);
                    $('#approvedEinvoices').text(response.data.einvoice_approved);
                    $('#rejectedEinvoices').text(response.data.einvoice_rejected);
                }
            })
            .fail(function() {
                showAlert('Failed to load statistics', 'error');
            });
    }

    function submitEinvoice(invoiceId) {
        showLoading();
        $.post(`/einvoices/${invoiceId}/submit`)
            .done(function(response) {
                hideLoading();
                if (response.success) {
                    showAlert(response.message, 'success');
                    location.reload();
                } else {
                    showAlert(response.message, 'error');
                }
            })
            .fail(function(xhr) {
                hideLoading();
                const response = xhr.responseJSON;
                showAlert(response?.message || 'Failed to submit e-invoice', 'error');
            });
    }

    function checkEinvoiceStatus(invoiceId) {
        showLoading();
        $.post(`/einvoices/${invoiceId}/check-status`)
            .done(function(response) {
                hideLoading();
                if (response.success) {
                    showAlert(response.message, 'success');
                    location.reload();
                } else {
                    showAlert(response.message, 'error');
                }
            })
            .fail(function(xhr) {
                hideLoading();
                const response = xhr.responseJSON;
                showAlert(response?.message || 'Failed to check status', 'error');
            });
    }

    function generateEinvoicePDF(invoiceId) {
        showLoading();
        $.post(`/einvoices/${invoiceId}/generate-pdf`)
            .done(function(response) {
                hideLoading();
                if (response.success) {
                    showAlert(response.message, 'success');
                    if (response.pdf_url) {
                        window.open(response.pdf_url, '_blank');
                    }
                } else {
                    showAlert(response.message, 'error');
                }
            })
            .fail(function(xhr) {
                hideLoading();
                const response = xhr.responseJSON;
                showAlert(response?.message || 'Failed to generate PDF', 'error');
            });
    }

    function bulkSubmitEinvoices(invoiceIds) {
        if (!confirm(`Are you sure you want to submit ${invoiceIds.length} invoices to e-invoice system?`)) {
            return;
        }

        showLoading();
        $.post('/einvoices/bulk-submit', {
            invoice_ids: invoiceIds,
            _token: '{{ csrf_token() }}'
        })
            .done(function(response) {
                hideLoading();
                if (response.success) {
                    showAlert(response.message, 'success');
                    location.reload();
                } else {
                    showAlert(response.message, 'error');
                }
            })
            .fail(function(xhr) {
                hideLoading();
                const response = xhr.responseJSON;
                showAlert(response?.message || 'Bulk submission failed', 'error');
            });
    }

    function showLoading() {
        $('#loadingModal').modal('show');
    }

    function hideLoading() {
        $('#loadingModal').modal('hide');
    }

    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('.container-fluid').prepend(alert);
        
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    }
});
</script>
@endsection
