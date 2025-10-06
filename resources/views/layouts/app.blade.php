<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nur Laman Bestari Eco Resort</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Body & Font Setup */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f1ee;
            color: #3e2723;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: #4e342e;
        }

        /* Hilton-Style Professional Navbar */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid #e5e5e5;
        }

        .navbar-brand {
            font-family: 'Merriweather', serif !important;
            font-weight: 700 !important;
            font-size: 1.4rem !important;
            color: #6d4c41 !important;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .navbar-brand:hover {
            color: #8d6e63 !important;
            transform: scale(1.02);
        }

        /* Enhanced Auth Buttons */
        .nav-item .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-width: 2px;
            text-decoration: none;
        }

        .nav-item .btn-outline-primary {
            color: #6d4c41;
            border-color: #6d4c41;
            background: transparent;
        }

        .nav-item .btn-outline-primary:hover {
            color: white;
            background-color: #6d4c41;
            border-color: #6d4c41;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(109, 76, 65, 0.3);
        }

        .nav-item .btn-primary {
            background-color: #6d4c41;
            border-color: #6d4c41;
            color: white;
        }

        .nav-item .btn-primary:hover {
            background-color: #5d4037;
            border-color: #5d4037;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(93, 64, 55, 0.3);
        }

        /* Ensure auth buttons are properly displayed */
        .navbar-nav .nav-item .btn {
            display: inline-block;
            white-space: nowrap;
            margin-left: 8px;
        }

        /* Force both auth buttons to be visible */
        @media (min-width: 992px) {
            .navbar-nav .nav-item:last-child .btn,
            .navbar-nav .nav-item:nth-last-child(2) .btn {
                display: inline-block !important;
            }
        }

        /* Mobile Responsive Auth Buttons */
        @media (max-width: 991px) {
            .nav-item .btn {
                margin: 5px 2px;
                display: inline-block;
                min-width: 100px;
            }
            
            .navbar-nav {
                text-align: center;
                flex-direction: row;
                justify-content: center;
            }
            
            .navbar-nav .nav-item {
                display: inline-block;
            }
        }

        @media (max-width: 576px) {
            .nav-item .btn {
                margin: 3px 1px;
                font-size: 0.8rem;
                padding: 6px 15px;
            }
        }

        .navbar-nav {
            align-items: center;
        }

        .nav-link {
            color: #333333 !important;
            font-weight: 500 !important;
            font-size: 0.9rem !important;
            padding: 0.75rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            position: relative;
            text-transform: none;
            letter-spacing: 0.3px;
        }

        .nav-link:hover {
            color: #6d4c41 !important;
            background: rgba(109, 76, 65, 0.05);
        }

        .nav-link.active {
            color: #6d4c41 !important;
            background: rgba(109, 76, 65, 0.08);
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -0.75rem;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 2px;
            background: #6d4c41;
        }

        /* Right side auth buttons */
        .navbar-nav .nav-item:nth-last-child(-n+2) .nav-link {
            background: transparent;
            border: 1px solid #6d4c41;
            color: #6d4c41 !important;
            font-weight: 600;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.3rem;
            border-radius: 4px;
        }

        .navbar-nav .nav-item:nth-last-child(-n+2) .nav-link:hover {
            background: #6d4c41;
            color: #ffffff !important;
        }

        .navbar-nav .nav-item:last-child .nav-link {
            background: #6d4c41;
            color: #ffffff !important;
            border: 1px solid #6d4c41;
        }

        .navbar-nav .nav-item:last-child .nav-link:hover {
            background: #8d6e63;
            border-color: #8d6e63;
        }

        /* User Dropdown Styling */
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            color: #6d4c41;
        }

        .dropdown-menu {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: #333333;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 4px;
            margin: 0.25rem;
        }

        .dropdown-item:hover {
            background: rgba(109, 76, 65, 0.05);
            color: #6d4c41;
        }

        .dropdown-divider {
            border-color: #e5e5e5;
            margin: 0.5rem 0;
        }

        /* Mobile Navbar Toggler */
        .navbar-toggler {
            border: 1px solid #6d4c41;
            border-radius: 4px;
            padding: 0.4rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(109, 76, 65, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23333' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                border-top: 1px solid #e5e5e5;
                margin-top: 1rem;
                padding-top: 1rem;
            }

            .nav-link {
                text-align: left;
                padding: 0.75rem 0 !important;
                margin: 0.25rem 0;
            }

            .navbar-nav .nav-item:nth-last-child(-n+2) .nav-link {
                margin: 0.5rem 0;
                text-align: center;
            }
        }

        /* Icons styling */
        .nav-link i {
            font-size: 0.85rem;
            margin-right: 0.4rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: #8d6e63;
            border-color: #8d6e63;
            color: #fff;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.5rem 1rem;
        }

        .btn-primary:hover {
            background-color: #7b5e57;
            border-color: #7b5e57;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: #fff8f5;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .card-title {
            color: #4e342e;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: #6d4c41;
            color: #fff;
            font-size: 0.9rem;
        }

        footer a {
            color: #ffccbc;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Links */
        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Professional Navbar -->
    <nav class="navbar navbar-expand-xl fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>NUR LAMAN BESTARI ECO RESORT</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Main Navigation -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                            <i class="fas fa-info-circle me-1"></i>About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('locations') ? 'active' : '' }}" href="{{ url('/locations') }}">
                            <i class="fas fa-map-marker-alt me-1"></i>Locations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('cabanas*') ? 'active' : '' }}" href="{{ route('cabanas.index') }}">
                            <i class="fas fa-home me-1"></i>Cabanas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('amenities') ? 'active' : '' }}" href="{{ url('/amenities') }}">
                            <i class="fas fa-concierge-bell me-1"></i>Amenities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">
                            <i class="fas fa-phone me-1"></i>Contact
                        </a>
                    </li>

                    <!-- Auth Links -->
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                                @if(auth()->user()->isAdmin())
                                    <span class="badge bg-success ms-1">Admin</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                @if(auth()->user()->isAdmin())
                                    <!-- Admin Menu -->
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.bookings.index') }}">
                                        <i class="fas fa-calendar-check me-2"></i>All Bookings
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.customers.index') }}">
                                        <i class="fas fa-users me-2"></i>Customers
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.payments.index') }}">
                                        <i class="fas fa-credit-card me-2"></i>Payments
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.cabanas.index') }}">
                                        <i class="fas fa-bed me-2"></i>Cabanas
                                    </a></li>
                                @else
                                    <!-- Customer Menu -->
                                    <li><a class="dropdown-item" href="{{ route('bookings.index') }}">
                                        <i class="fas fa-calendar-check me-2"></i>My Bookings
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Guest Authentication Links -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i>Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">Customer Access</h6></li>
                                <li><a class="dropdown-item" href="{{ route('customer.login') }}">
                                    <i class="fas fa-sign-in-alt me-2"></i>Customer Login
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.register') }}">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Spacer for Fixed Navbar -->
    <div style="height: 80px;"></div>

    <!-- Page Content -->
    <main class="container py-5">
        @yield('content')
    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
