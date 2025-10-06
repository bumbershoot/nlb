@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">👥 Staff Management</h1>
                @if(Auth::user()->canManageStaff())
                <a href="{{ route('admin.staff.invite') }}" class="btn btn-success">
                    <i class="fas fa-user-plus me-2"></i>Invite Staff
                </a>
                @endif
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

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h3 class="text-primary">{{ $staff->where('status', 'active')->count() }}</h3>
                            <p class="text-muted mb-0">Active Staff</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h3 class="text-warning">{{ $pendingCount }}</h3>
                            <p class="text-muted mb-0">Pending Invitations</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h3 class="text-info">{{ $staff->where('admin_role', 'manager')->count() }}</h3>
                            <p class="text-muted mb-0">Managers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success">{{ $staff->where('admin_role', 'staff')->count() }}</h3>
                            <p class="text-muted mb-0">Staff Members</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Staff Members</h5>
                </div>
                <div class="card-body">
                    @if($staff->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Invited By</th>
                                        <th>Joined</th>
                                        @if(Auth::user()->canManageStaff())
                                        <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $member)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </div>
                                                {{ $member->name }}
                                            </div>
                                        </td>
                                        <td>{{ $member->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $member->admin_role === 'super_admin' ? 'danger' : 
                                                ($member->admin_role === 'manager' ? 'warning' : 
                                                ($member->admin_role === 'staff' ? 'info' : 'secondary')) 
                                            }}">
                                                {{ $member->admin_role_display }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $member->status === 'active' ? 'success' : ($member->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $member->invited_by ?: 'System' }}</td>
                                        <td>{{ $member->created_at->format('M d, Y') }}</td>
                                        @if(Auth::user()->canManageStaff())
                                        <td>
                                            @if($member->admin_role !== 'super_admin' && $member->id !== Auth::id())
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editStaffModal{{ $member->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="confirmDelete('{{ $member->name }}', '{{ route('admin.staff.destroy', $member) }}')">
                                                    Remove
                                                </button>
                                            </div>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>

                                    @if(Auth::user()->canManageStaff() && $member->admin_role !== 'super_admin')
                                    <!-- Edit Staff Modal -->
                                    <div class="modal fade" id="editStaffModal{{ $member->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('admin.staff.update', $member) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit {{ $member->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="admin_role{{ $member->id }}" class="form-label">Role</label>
                                                            <select name="admin_role" id="admin_role{{ $member->id }}" class="form-select" required>
                                                                <option value="manager" {{ $member->admin_role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                                <option value="staff" {{ $member->admin_role === 'staff' ? 'selected' : '' }}>Staff</option>
                                                                <option value="read_only" {{ $member->admin_role === 'read_only' ? 'selected' : '' }}>Read Only</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status{{ $member->id }}" class="form-label">Status</label>
                                                            <select name="status" id="status{{ $member->id }}" class="form-select" required>
                                                                <option value="active" {{ $member->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="suspended" {{ $member->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Staff</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No staff members found</h5>
                            @if(Auth::user()->canManageStaff())
                            <p class="text-muted">Start by inviting your first staff member.</p>
                            <a href="{{ route('admin.staff.invite') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Invite Staff
                            </a>
                            @endif
                        </div>
                    @endif
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
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove <strong id="deleteName"></strong> from staff?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remove Staff</button>
                </form>
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

<script>
function confirmDelete(name, url) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = url;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
