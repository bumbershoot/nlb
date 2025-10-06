@extends('layouts.app')

@section('content')
<!-- Custom Styles for Beautiful Login Form -->
<style>
    .login-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }
    
    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat;
        background-size: cover;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: none;
        border-radius: 25px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: all 0.4s ease;
        position: relative;
    }
    
    .login-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.25);
    }
    
    .login-header {
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        color: white;
        padding: 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .login-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 4s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .login-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }
    
    .login-subtitle {
        margin: 15px 0 0 0;
        opacity: 0.9;
        font-size: 1.2rem;
        font-weight: 300;
    }
    
    .welcome-text {
        margin-top: 10px;
        font-size: 1rem;
        opacity: 0.8;
    }
    
    .form-floating {
        margin-bottom: 25px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 18px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        height: auto;
    }
    
    .form-control:focus {
        border-color: #6d4c41;
        box-shadow: 0 0 25px rgba(109, 76, 65, 0.4);
        background: rgba(255, 255, 255, 1);
        transform: translateY(-3px);
    }
    
    .form-label {
        color: #6d4c41;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-group {
        position: relative;
    }
    
    .form-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #6d4c41;
        opacity: 0.6;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .form-control:focus + .form-label + .form-icon {
        opacity: 1;
        color: #6d4c41;
        transform: translateY(-50%) scale(1.1);
    }
    
    .remember-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 25px 0;
        padding: 15px;
        background: rgba(109, 76, 65, 0.05);
        border-radius: 12px;
        border: 1px solid rgba(109, 76, 65, 0.1);
    }
    
    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
    }
    
    .custom-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #6d4c41;
        cursor: pointer;
    }
    
    .custom-checkbox label {
        color: #6d4c41;
        font-weight: 500;
        cursor: pointer;
        margin: 0;
    }
    
    .forgot-password {
        color: #8d6e63;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .forgot-password:hover {
        color: #6d4c41;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .btn-login {
        background: linear-gradient(135deg, #6d4c41, #8d6e63);
        border: none;
        border-radius: 25px;
        padding: 18px 40px;
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
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.6s;
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(109, 76, 65, 0.4);
        background: linear-gradient(135deg, #8d6e63, #6d4c41);
    }
    
    .register-link {
        text-align: center;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }
    
    .register-link a {
        color: #6d4c41;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .register-link a:hover {
        color: #8d6e63;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
    
    .invalid-feedback {
        display: block;
        font-size: 14px;
        color: #dc3545;
        margin-top: 10px;
        font-weight: 500;
        padding: 8px 12px;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 8px;
        border-left: 4px solid #dc3545;
    }
    
    .login-decorations {
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .decoration-1 {
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .decoration-2 {
        top: 20%;
        right: 15%;
        animation-delay: 2s;
    }
    
    .decoration-3 {
        bottom: 15%;
        left: 20%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
</style>

<div class="login-container">
    <!-- Floating Decorations -->
    <div class="login-decorations decoration-1"></div>
    <div class="login-decorations decoration-2"></div>
    <div class="login-decorations decoration-3"></div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card login-card">
                    <!-- Beautiful Header -->
                    <div class="login-header">
                        <h2 class="login-title">
                            <i class="fas fa-sign-in-alt"></i>
                            Welcome Back
                        </h2>
                        <p class="login-subtitle">Sign in to your account</p>
                        <p class="welcome-text">Nur Laman Bestari Eco Resort</p>
                    </div>

                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="email" autofocus
                                           placeholder="Email Address">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <i class="fas fa-envelope form-icon"></i>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <div class="form-floating">
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="current-password"
                                           placeholder="Password">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                    <i class="fas fa-lock form-icon"></i>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="remember-section">
                                <div class="custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        <i class="fas fa-heart me-1"></i>Remember Me
                                    </label>
                                </div>
                                
                                @if (Route::has('password.request'))
                                    <a class="forgot-password" href="{{ route('password.request') }}">
                                        <i class="fas fa-key me-1"></i>Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="btn btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Sign In to My Account
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>

                            <!-- Register Link -->
                            <div class="register-link">
                                <p class="text-muted mb-2">Don't have an account yet?</p>
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    <i class="fas fa-user-plus me-1"></i>Create new account
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
