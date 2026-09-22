<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GCW Hostel Management')</title>
    
    <!-- Critical CSS to prevent flash - Load this first -->
    <style>
        /* Critical styles to prevent flash */
        .navbar {
            background: linear-gradient(135deg, #e8dcc8 0%, #f5efe6 50%, #e8dcc8 100%) !important;
            padding: 10px 0;
            box-shadow: 0 2px 20px rgba(139, 115, 85, 0.15);
            border-bottom: 3px solid #8B6B4A;
            display: flex;
            align-items: center;
            min-height: 70px;
        }
        .navbar-brand {
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #4A3228 !important;
            font-size: 24px;
            text-decoration: none;
        }
        .nav-link {
            color: #4A3228 !important;
            font-weight: 500;
            text-decoration: none;
        }
        .nav-link:hover {
            color: #8B6B4A !important;
        }
        .nav-link.active {
            color: #8B6B4A !important;
        }
        .btn-book {
            background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%);
            color: #ffffff !important;
            border: 2px solid #8B6B4A;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            text-decoration: none;
        }
        /* Hide content until fully loaded - prevents flash */
        .navbar, .main-content {
            opacity: 0;
            animation: fadeIn 0.01s ease forwards;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="{{ asset('css/room.css') }}" rel="stylesheet">
    <link href="{{ asset('css/features.css') }}" rel="stylesheet">
    
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* --- FULL NAVIGATION STYLES --- */
        .navbar {
            background: linear-gradient(135deg, #e8dcc8 0%, #f5efe6 50%, #e8dcc8 100%) !important;
            padding: 10px 0;
            box-shadow: 0 2px 20px rgba(139, 115, 85, 0.15);
            color: #4A3228 !important;
            border-bottom: 3px solid #8B6B4A;
        }
        .navbar-brand {
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #4A3228 !important;
            font-size: 24px;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover {
            color: #8B6B4A !important;
        }
        
        .nav-logo-img {
            width: 60px;
            height: auto;
            transition: transform 0.3s ease;
        }
        .nav-logo-img:hover {
            transform: scale(1.05);
        }

        /* --- BRAND TEXT STYLING (PROFESSIONAL) --- */
        .brand-text-wrapper {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
            margin-left: 8px;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #4A3228;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 11px;
            font-weight: 500;
            color: #8B6B4A;
            letter-spacing: 3px;
            margin-top: 2px;
            line-height: 1;
        }

        /* --- NAVIGATION LINKS --- */
        .nav-link {
            color: #4A3228 !important;
            margin: 0 15px;
            font-weight: 500;
            position: relative;
            padding: 5px 0 !important;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #8B6B4A;
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .nav-link:hover {
            color: #8B6B4A !important;
        }

        .nav-link:hover::after {
            width: 100%;
        }
        
        .nav-link.active {
            color: #8B6B4A !important;
        }
        .nav-link.active::after {
            width: 100%;
            background-color: #8B6B4A;
        }
        
        /* --- BOOK NOW BUTTON --- */
        .btn-pill {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            margin-left: 10px;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-book { 
            background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%);
            color: #ffffff !important;
            border: 2px solid #8B6B4A;
            box-shadow: 0 4px 15px rgba(139, 115, 85, 0.25);
        }
        .btn-book:hover { 
            background: linear-gradient(135deg, #6B5544 0%, #8B6B4A 100%);
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(139, 115, 85, 0.3);
            border-color: #6B5544;
        }

        /* --- PROFILE DROPDOWN --- */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }
        .profile-btn {
            background: rgba(139, 115, 85, 0.15);
            border: 2px solid rgba(139, 115, 85, 0.2);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4A3228;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            backdrop-filter: blur(10px);
            padding: 0;
            overflow: hidden;
        }
        .profile-btn:hover {
            background: rgba(139, 115, 85, 0.25);
            border-color: #8B6B4A;
            transform: scale(1.05);
            color: #8B6B4A;
        }
        .profile-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-btn i {
            font-size: 1.5rem;
            color: #8B6B4A;
        }
        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .profile-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 55px;
            background: #FFFFFF;
            min-width: 220px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
            z-index: 1000;
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: slideDown 0.3s ease;
        }
        .profile-dropdown-menu.show {
            display: block;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .profile-dropdown-menu .dropdown-item {
            padding: 10px 20px;
            color: #4A3228;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        .profile-dropdown-menu .dropdown-item:hover {
            background: #f5efe6;
            color: #8B6B4A;
        }
        .profile-dropdown-menu .dropdown-item i {
            width: 20px;
            color: #8B6B4A;
            transition: color 0.2s ease;
        }
        .profile-dropdown-menu .dropdown-item:hover i {
            color: #8B6B4A;
        }
        .profile-dropdown-menu .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 5px 0;
        }
        .profile-dropdown-menu .dropdown-header {
            padding: 10px 20px;
            font-weight: 600;
            color: #4A3228;
            font-size: 0.85rem;
        }
        .profile-dropdown-menu .dropdown-header small {
            display: block;
            font-weight: 400;
            color: #6b7280;
            font-size: 0.75rem;
        }
        .profile-dropdown-menu .dropdown-item.text-danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        .profile-dropdown-menu .dropdown-item.text-danger i {
            color: #dc2626;
        }
        .profile-dropdown-menu .dropdown-item.text-danger:hover i {
            color: #dc2626;
        }

        /* --- AUTH BUTTONS --- */
        .auth-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .btn-auth {
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
        }
        .btn-login {
            background: rgba(139, 115, 85, 0.12);
            color: #4A3228;
            border: 1px solid rgba(139, 115, 85, 0.2);
        }
        .btn-login:hover {
            background: rgba(139, 115, 85, 0.2);
            color: #8B6B4A;
            border-color: #8B6B4A;
            transform: translateY(-2px);
        }
        .btn-register {
            background: linear-gradient(135deg, #8B6B4A 0%, #A8825A 100%);
            color: #FFFFFF;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #6B5544 0%, #8B6B4A 100%);
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(139, 115, 85, 0.3);
        }

        /* --- FIXED FOOTER STYLING --- */
        .footer-main {
            background: linear-gradient(135deg, #2A1A0E 0%, #4A3228 50%, #3D2B1F 100%);
            color: #FFFFFF;
            padding: 80px 0 40px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .footer-logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #FFFFFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .footer-logo-text:hover {
            color: #C49A6C;
        }

        .footer-logo-img {
            width: 80px;
            height: auto;
            filter: none;
        }

        .footer-about-text {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .footer-nav-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
            color: #FFFFFF;
        }

        .footer-nav-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, #C49A6C, #A8825A);
        }

        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }
        .footer-links a:hover { 
            color: #C49A6C;
            padding-left: 5px;
        }
        
        .contact-info-list {
            list-style: none;
            padding: 0;
        }

        .contact-info-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            color: rgba(255,255,255,0.8);
        }

        .contact-info-list i {
            font-size: 18px;
            color: #C49A6C;
        }

        .social-links { display: flex; gap: 15px; }
        .social-links a { 
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #FFFFFF; 
            transition: 0.3s; 
            text-decoration: none;
        }
        .social-links a:hover { 
            background: #C49A6C;
            color: #FFFFFF;
            transform: translateY(-3px);
        }

        .footer-sub-bar {
            background: #1A0E08;
            padding: 20px 0;
            font-size: 14px;
            color: rgba(255,255,255,0.5);
            border-top: 2px solid rgba(196, 154, 108, 0.2);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .navbar-nav {
                padding: 15px 0;
            }
            .auth-buttons {
                margin-top: 10px;
                flex-wrap: wrap;
            }
            .profile-dropdown-menu {
                right: auto;
                left: 0;
            }
        }
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 18px;
            }
            .nav-logo-img {
                width: 45px;
            }
            .brand-title {
                font-size: 18px;
            }
            .brand-subtitle {
                font-size: 9px;
                letter-spacing: 2px;
            }
            .btn-pill {
                padding: 8px 18px;
                font-size: 13px;
            }
            .footer-logo-text {
                font-size: 22px;
            }
            .footer-logo-img {
                width: 60px;
            }
        }
        @media (max-width: 576px) {
            .brand-title {
                font-size: 15px;
            }
            .brand-subtitle {
                font-size: 8px;
                letter-spacing: 2px;
            }
            .profile-btn {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }
            .profile-btn i {
                font-size: 1.2rem;
            }
            .profile-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('Assert/logo.png') }}" alt="Logo" class="nav-logo-img"> 
                <span class="brand-text-wrapper">
                    <span class="brand-title">GCW HOSTEL</span>
                    <span class="brand-subtitle">Management</span>
                </span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Book Now Button -->
                    <a href="{{ route('booking') }}" class="btn btn-pill btn-book">Book Now </a>

                    <!-- Auth Section -->
                    @auth
                        <!-- User is logged in - Show Profile with Icon -->
                        <div class="profile-dropdown">
                            <button class="profile-btn" onclick="toggleDropdown()" aria-label="Profile">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </button>
                            <div class="profile-dropdown-menu" id="profileDropdown">
                                <div class="dropdown-header">
                                    {{ Auth::user()->name ?? 'User' }}
                                    <small>{{ Auth::user()->email ?? '' }}</small>
                                </div>
                                <div class="dropdown-divider"></div>
                                
                                <!-- My Profile -->
                                @if(Route::has('profile'))
                                    <a href="{{ route('profile') }}" class="dropdown-item">
                                        <i class="bi bi-person-circle"></i> My Profile
                                    </a>
                                @else
                                    <a href="#" class="dropdown-item" onclick="alert('Profile page coming soon!')">
                                        <i class="bi bi-person-circle"></i> My Profile
                                    </a>
                                @endif
                                
                                <!-- Complaint & Dashboard Options - Conditional based on role -->
                                @php
                                    $userRole = Auth::user()->role ?? 'user';
                                @endphp
                                
                                {{-- Sirf normal user ko Submit Complaint dikhao --}}
                                @if($userRole === 'user' && Route::has('complaint.registration'))
                                    <a href="{{ route('complaint.registration') }}" class="dropdown-item">
                                        <i class="bi bi-exclamation-triangle"></i> Submit Complaint
                                    </a>
                                @endif
                                
                                {{-- Admin aur Clerk ko Manage Complaints dikhao --}}
                                @if(in_array($userRole, ['admin', 'clerk']) && Route::has('complaints.index'))
                                    <a href="{{ route('complaints.index') }}" class="dropdown-item">
                                        <i class="bi bi-list-check"></i> Manage Complaints
                                    </a>
                                @endif
                                
                                {{-- Admin aur Clerk ko Dashboard dikhao --}}
                                @if(in_array($userRole, ['admin', 'clerk']))
                                    <div class="dropdown-divider"></div>
                                    @if(Route::has('dashboard'))
                                        <a href="{{ route('dashboard') }}" class="dropdown-item">
                                            <i class="bi bi-speedometer2"></i> Dashboard
                                        </a>
                                    @endif
                                @endif
                                
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- User is not logged in - Show Login/Register -->
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn-auth btn-login">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                            <a href="{{ route('signup') }}" class="btn-auth btn-register">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-main">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="footer-logo-text">
                        <img src="{{ asset('Assert/logo.png') }}" alt="GCW" class="footer-logo-img"> 
                        GCW Hostel Management
                    </a>
                    <p class="footer-about-text">
                        GCW Girls Hostel provides a safe, secure, and nurturing environment specifically designed for female students and professionals.
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/share/1Cd5uQRT1W/" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/ggcw_grw_official?igsh=b2UycmxwbHRpZ2lo" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/923157180041" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-nav-title">Navigation</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Our Services</a></li>
                        <li><a href="{{ route('rooms') }}">Room Gallery</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-nav-title">Explore</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('gallery') }}">Photo Gallery</a></li>
                        <li><a href="{{ route('faq') }}">Hostel FAQs</a></li>
                        <li><a href="{{ route('rules') }}">Hostel Rules</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-nav-title">Contact Info</h5>
                    <ul class="contact-info-list">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span>Satellite Town, Gujranwala, Pakistan</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <span>0315-7180041</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <span>info@gcwhostel.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="footer-sub-bar text-center">
        <div class="container">
            <span>© {{ date('Y') }} GCW Hostel. All rights reserved. Built for GCW Students.</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileBtn = document.querySelector('.profile-btn');
            
            if (!profileBtn?.contains(event.target) && !dropdown?.contains(event.target)) {
                dropdown?.classList.remove('show');
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('profileDropdown')?.classList.remove('show');
            }
        });

        document.addEventListener('scroll', function() {
            document.getElementById('profileDropdown')?.classList.remove('show');
        });

        console.log('✅ GCW Hostel App loaded successfully');
    </script>
</body>
</html>