@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #2c5aa0, #4a90e2); border-radius: 20px 20px 0 0;">
                    <h3 class="text-white mb-0">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </h3>
                    <p class="text-white-50 mb-0 mt-2">Join Nur Laman Bestari Eco Resort Community</p>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <small>{{ $error }}</small><br>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customer.register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2 text-muted"></i>Full Name
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autocomplete="name" 
                                           autofocus
                                           placeholder="John Doe"
                                           style="border-radius: 10px;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-2 text-muted"></i>Phone Number
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="+60123456789"
                                           style="border-radius: 10px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email"
                                   placeholder="your@email.com"
                                   style="border-radius: 10px;">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-2 text-muted"></i>Password
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Minimum 8 characters"
                                           style="border-radius: 10px;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-2 text-muted"></i>Confirm Password
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Repeat password"
                                           style="border-radius: 10px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold" 
                                    style="border-radius: 15px; padding: 15px; transition: all 0.3s ease;">
                                <i class="fas fa-user-plus me-2"></i>Create My Account
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-3">Already have an account?</p>
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Account
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-2"></i>Resort Admin? 
                            <a href="{{ route('admin.register') }}" class="text-decoration-none">Register here</a>
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
