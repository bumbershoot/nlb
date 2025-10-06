@extends('layouts.app')

@section('content')
<!-- Custom Styles for Beautiful Register Form -->
<style>
    .register-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .register-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: none;
        border-radius: 25px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 60px rgba(0, 0, 0, 0.2);
    }
    
    .register-header {
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .register-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .register-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .register-subtitle {
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .form-floating {
        margin-bottom: 25px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .form-control:focus {
        border-color: #6d4c41;
        box-shadow: 0 0 20px rgba(109, 76, 65, 0.3);
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
    }
    
    .form-label {
        color: #6d4c41;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-register {
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        border: none;
        border-radius: 25px;
        padding: 15px 40px;
        font-size: 18px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-top: 20px;
    }
    
    .btn-register::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-register:hover::before {
        left: 100%;
    }
    
    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(109, 76, 65, 0.4);
        background: linear-gradient(135deg, #8d6e63, #6d4c41);
    }
    
    .login-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .login-link a {
        color: #6d4c41;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .login-link a:hover {
        color: #8d6e63;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .invalid-feedback {
        display: block;
        font-size: 14px;
        color: #dc3545;
        margin-top: 8px;
        font-weight: 500;
    }
    
    .form-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #6d4c41;
        opacity: 0.6;
        transition: all 0.3s ease;
    }
    
    .form-group {
        position: relative;
    }
</style>

<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card register-card">
                    <!-- Beautiful Header -->
                    <div class="register-header">
                        <h2 class="register-title">
                            <i class="fas fa-user-plus me-3"></i>Create Account
                        </h2>
                        <p class="register-subtitle">Join Nur Laman Bestari Eco Resort</p>
                    </div>

                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="name" type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" 
                                           required autocomplete="name" autofocus
                                           placeholder="Full Name">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>Full Name
                                    </label>
                                    <i class="fas fa-user form-icon"></i>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="email"
                                           placeholder="Email Address">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <i class="fas fa-envelope form-icon"></i>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password"
                                           placeholder="Password">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                    <i class="fas fa-lock form-icon"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="password-confirm" type="password" 
                                           class="form-control" name="password_confirmation" 
                                           required autocomplete="new-password"
                                           placeholder="Confirm Password">
                                    <label for="password-confirm" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirm Password
                                    </label>
                                    <i class="fas fa-check-circle form-icon"></i>
                                </div>
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-register">
                                <i class="fas fa-user-plus me-2"></i>
                                Create My Account
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>

                            <!-- Login Link -->
                            <div class="login-link">
                                <p class="text-muted mb-2">Already have an account?</p>
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-1"></i>Sign in here
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
