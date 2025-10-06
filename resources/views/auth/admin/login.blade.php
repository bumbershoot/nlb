@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #6d4c41, #8d6e63); border-radius: 20px 20px 0 0;">
                    <h3 class="text-white mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Admin Login
                    </h3>
                    <p class="text-white-50 mb-0 mt-2">Resort Management Access</p>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <small>{{ $error }}</small>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-muted"></i>Admin Email
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="admin@resort.com"
                                   style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-muted"></i>Password
                            </label>
                            <input type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Enter your admin password"
                                   style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-lg fw-bold" 
                                    style="background: linear-gradient(135deg, #6d4c41, #8d6e63); 
                                           border: none; 
                                           border-radius: 15px; 
                                           color: white;
                                           padding: 15px;
                                           transition: all 0.3s ease;">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-3">Need admin access?</p>
                        <a href="{{ route('admin.register') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Register as Admin
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-users me-2"></i>Customer? 
                            <a href="{{ route('customer.login') }}" class="text-decoration-none">Login here</a>
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.form-control:focus {
    border-color: #6d4c41;
    box-shadow: 0 0 0 0.2rem rgba(109, 76, 65, 0.25);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(109, 76, 65, 0.3);
}
</style>
@endsection
