@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #2c5aa0, #4a90e2); border-radius: 20px 20px 0 0;">
                    <h3 class="text-white mb-0">
                        <i class="fas fa-user me-2"></i>Customer Login
                    </h3>
                    <p class="text-white-50 mb-0 mt-2">Access Your Bookings</p>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <small>{{ $error }}</small>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="your@email.com"
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
                                   placeholder="Enter your password"
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
                            <button type="submit" class="btn btn-primary btn-lg fw-bold" 
                                    style="border-radius: 15px; padding: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Account
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-3">Don't have an account?</p>
                        <a href="{{ route('customer.register') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-2"></i>Resort Admin? 
                            <a href="{{ route('admin.login') }}" class="text-decoration-none">Login here</a>
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(74, 144, 226, 0.3);
}
</style>
@endsection
