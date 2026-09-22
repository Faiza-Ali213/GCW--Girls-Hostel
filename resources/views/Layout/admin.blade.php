<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | GCW Hostel</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --gcw-primary: #4F46E5;
            --gcw-primary-light: #818CF8;
            --gcw-primary-dark: #4338CA;
            --gcw-secondary: #EF4444;
            --gcw-green: #10B981;
            --gcw-dark: #1E293B;
            --bg-light: #F1F5F9;
            --sidebar-bg: #FFFFFF;
            --sidebar-text: #64748B;
            --sidebar-hover: #F1F5F9;
            --sidebar-active-bg: #EEF2FF;
            --sidebar-border: #E2E8F0;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--gcw-primary-light);
            border-radius: 10px;
        }

        /* Logo Section */
        .sidebar-logo {
            padding: 25px 25px 20px;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .logo-text {
            color: var(--gcw-dark);
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .logo-text span {
            color: var(--gcw-primary);
        }

        .logo-subtext {
            color: var(--sidebar-text);
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 1px;
        }

        /* Navigation */
        .nav-section {
            padding: 20px 16px 10px;
            color: var(--sidebar-text);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .nav-list {
            list-style: none;
            padding: 0 12px;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 16px;
            text-decoration: none;
            color: var(--sidebar-text);
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-custom i {
            font-size: 20px;
            width: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .nav-link-custom .nav-icon-wrapper {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .nav-link-custom .nav-icon-wrapper i {
            color: var(--sidebar-text);
        }

        .nav-link-custom .nav-text {
            flex: 1;
        }

        .nav-link-custom .nav-badge {
            background: var(--gcw-secondary);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }

        /* Hover State */
        .nav-link-custom:hover {
            background: var(--sidebar-hover);
            color: var(--gcw-dark);
        }

        .nav-link-custom:hover .nav-icon-wrapper {
            background: var(--gcw-primary);
        }

        .nav-link-custom:hover .nav-icon-wrapper i {
            color: white;
        }

        /* Active State - Light Theme */
        .nav-item.active .nav-link-custom {
            background: var(--sidebar-active-bg);
            color: var(--gcw-primary);
        }

        .nav-item.active .nav-link-custom .nav-icon-wrapper {
            background: var(--gcw-primary);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .nav-item.active .nav-link-custom .nav-icon-wrapper i {
            color: white;
        }

        /* Active Indicator */
        .nav-item.active .nav-link-custom::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--gcw-primary);
            border-radius: 0 4px 4px 0;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 16px 12px 24px;
            border-top: 1px solid var(--sidebar-border);
            margin-top: auto;
        }

        .footer-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--sidebar-border), transparent);
            margin-bottom: 12px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 16px;
            text-decoration: none;
            color: var(--sidebar-text);
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
        }

        .logout-btn i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .logout-btn .nav-icon-wrapper {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #FEF2F2;
            transition: all 0.3s ease;
        }

        .logout-btn .nav-icon-wrapper i {
            color: var(--gcw-secondary);
        }

        .logout-btn:hover {
            background: #FEF2F2;
            color: var(--gcw-secondary);
        }

        .logout-btn:hover .nav-icon-wrapper {
            background: var(--gcw-secondary);
        }

        .logout-btn:hover .nav-icon-wrapper i {
            color: white;
        }

        /* ========== TOP NAVBAR ========== */
        .top-navbar {
            margin-left: var(--sidebar-width);
            padding: 16px 35px;
            background: white;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: var(--card-shadow);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--gcw-dark);
            cursor: pointer;
            padding: 4px 8px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--gcw-dark);
            margin: 0;
        }

        .page-title span {
            color: var(--sidebar-text);
            font-weight: 400;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Notification Icon & Dropdown */
        .notification-wrapper {
            position: relative;
        }

        .notification-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            background: var(--bg-light);
            color: var(--gcw-dark);
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .notification-btn:hover {
            background: #E2E8F0;
            transform: scale(1.05);
        }

        .notification-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 10px;
            height: 10px;
            background: var(--gcw-secondary);
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse-dot 2s infinite;
            display: {{ $unreadCount > 0 ? 'block' : 'none' }};
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        /* Notification Dropdown */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: -10px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 48px rgba(0,0,0,0.15);
            width: 380px;
            max-height: 480px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.96);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--sidebar-border);
            overflow: hidden;
            z-index: 1001;
        }

        .notification-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .notification-dropdown-header {
            padding: 16px 20px 12px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-dropdown-header h6 {
            font-weight: 600;
            color: var(--gcw-dark);
            margin: 0;
            font-size: 15px;
        }

        .notification-dropdown-header .mark-all-read {
            font-size: 12px;
            color: var(--gcw-primary);
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
        }

        .notification-dropdown-header .mark-all-read:hover {
            text-decoration: underline;
        }

        .notification-list {
            max-height: 320px;
            overflow-y: auto;
            padding: 4px 0;
        }

        .notification-list::-webkit-scrollbar {
            width: 4px;
        }
        .notification-list::-webkit-scrollbar-track {
            background: transparent;
        }
        .notification-list::-webkit-scrollbar-thumb {
            background: var(--gcw-primary-light);
            border-radius: 10px;
        }

        /* Notification item as clickable link */
        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px 20px;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }

        .notification-item:hover {
            background: var(--bg-light);
            text-decoration: none;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item .notif-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .notification-item .notif-icon.primary {
            background: #EEF2FF;
            color: var(--gcw-primary);
        }

        .notification-item .notif-icon.success {
            background: #ECFDF5;
            color: var(--gcw-green);
        }

        .notification-item .notif-icon.warning {
            background: #FFFBEB;
            color: #F59E0B;
        }

        .notification-item .notif-icon.danger {
            background: #FEF2F2;
            color: var(--gcw-secondary);
        }

        .notification-item .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notification-item .notif-content .notif-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--gcw-dark);
            margin: 0 0 2px;
        }

        .notification-item .notif-content .notif-text {
            font-size: 13px;
            color: var(--sidebar-text);
            margin: 0 0 4px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-item .notif-content .notif-time {
            font-size: 11px;
            color: #94A3B8;
        }

        .notification-item .notif-badge {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gcw-primary);
            flex-shrink: 0;
            margin-top: 6px;
        }

        .notification-item.read .notif-badge {
            background: transparent;
        }

        .notification-empty {
            padding: 30px 20px;
            text-align: center;
            color: #94a3b8;
        }

        .notification-empty i {
            font-size: 32px;
            display: block;
            margin-bottom: 8px;
            color: #d1d5db;
        }

        .notification-empty p {
            margin: 0;
            font-size: 14px;
        }

        .notification-dropdown-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--sidebar-border);
            text-align: center;
        }

        .notification-dropdown-footer .view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--gcw-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 6px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .notification-dropdown-footer .view-all-btn:hover {
            background: var(--bg-light);
        }

        .notification-dropdown-footer .view-all-btn i {
            font-size: 14px;
        }

        /* Profile Dropdown */
        .profile-wrapper {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px 6px 6px;
            border-radius: 50px;
            border: none;
            background: var(--bg-light);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-btn:hover {
            background: #E2E8F0;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gcw-primary);
        }

        .profile-info {
            text-align: left;
            line-height: 1.2;
        }

        .profile-info .name {
            font-size: 13px;
            font-weight: 600;
            color: var(--gcw-dark);
            margin: 0;
        }

        .profile-info .role {
            font-size: 11px;
            color: var(--sidebar-text);
            margin: 0;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            min-width: 220px;
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            border: 1px solid var(--sidebar-border);
        }

        .profile-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            text-decoration: none;
            color: var(--gcw-dark);
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item i {
            font-size: 16px;
            width: 20px;
            color: var(--sidebar-text);
        }

        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--gcw-primary);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--sidebar-border);
            margin: 6px 20px;
        }

        .dropdown-item.text-danger:hover {
            color: var(--gcw-secondary);
        }

        /* ========== MAIN CONTENT ========== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 30px 35px;
            min-height: calc(100vh - 74px);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .top-navbar {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
            .hamburger-btn {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .top-navbar {
                padding: 12px 16px;
            }
            .main-wrapper {
                padding: 16px;
            }
            .page-title {
                font-size: 16px;
            }
            .profile-info {
                display: none;
            }
            .profile-btn {
                padding: 4px;
            }
            .notification-dropdown {
                width: 340px;
                right: -70px;
            }
        }

        /* ========== OVERLAY ========== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            z-index: 999;
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* ========== CARD STYLES ========== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid var(--sidebar-border);
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
        }

        /* Unread notification styling */
        .notification-item.unread {
            background: #F8FAFF;
        }
        .notification-item.unread .notif-title {
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
@stack('scripts')
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @php
        $isClerk = Auth::check() && Auth::user()->isClerk();
    @endphp

    <!-- ========== SIDEBAR ========== -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="logo-wrapper">
                <img src="{{ asset('Assert/logo.png') }}" alt="GCW Hostel" class="logo-image">
                <div>
                    <div class="logo-text">GCW<span>Hostel</span></div>
                    <div class="logo-subtext">{{ $isClerk ? 'Clerk Panel' : 'Admin Panel' }}</div>
                </div>
            </div>
        </div>

        @if($isClerk)
            {{-- ============ CLERK SIDEBAR (Fee Record Only) ============ --}}
            <div class="nav-section">Clerk Menu</div>
            <ul class="nav-list">
                <li class="nav-item {{ request()->routeIs('fee_record') ? 'active' : '' }}">
                    <a href="{{ route('fee_record') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-cash-stack"></i></span>
                        <span class="nav-text">Fee Record</span>
                    </a>
                </li>
            </ul>
        @else
            {{-- ============ ADMIN SIDEBAR (Full Access) ============ --}}
            <!-- Navigation -->
            <div class="nav-section">Main Menu</div>
            <ul class="nav-list">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-grid-fill"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('student-records') ? 'active' : '' }}">
                    <a href="{{ route('student-records') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-people-fill"></i></span>
                        <span class="nav-text">Student Records</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('room_allocation') ? 'active' : '' }}">
                    <a href="{{ route('room_allocation') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-door-open-fill"></i></span>
                        <span class="nav-text">Room Allocation</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('fee_record') ? 'active' : '' }}">
                    <a href="{{ route('fee_record') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-cash-stack"></i></span>
                        <span class="nav-text">Fee Record</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('staff_records') ? 'active' : '' }}">
                    <a href="{{ route('staff_records') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-person-badge-fill"></i></span>
                        <span class="nav-text">Staff Records</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('vistors_records') ? 'active' : '' }}">
                    <a href="{{ route('vistors_records') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-person-check-fill"></i></span>
                        <span class="nav-text">Visitors</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('Complain_request') ? 'active' : '' }}">
                    <a href="{{ route('Complain_request') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-exclamation-triangle-fill"></i></span>
                        <span class="nav-text">Complaints</span>
                    </a>
                </li>
            </ul>

            <!-- Settings Section -->
            <div class="nav-section">System</div>
            <ul class="nav-list">
                <!-- Notification Page Link -->
                <li class="nav-item {{ request()->routeIs('notification') || request()->routeIs('notifications.index') ? 'active' : '' }}">
                    <a href="{{ route('notification') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-bell-fill"></i></span>
                        <span class="nav-text">Notifications</span>
                        @if($unreadCount > 0)
                            <span class="nav-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper">
                            <i class="bi bi-people"></i>
                        </span>
                        <span class="nav-text">User Management</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <a href="{{ route('settings') }}" class="nav-link-custom">
                        <span class="nav-icon-wrapper"><i class="bi bi-gear-fill"></i></span>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        @endif

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="footer-divider"></div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button class="logout-btn" onclick="confirmLogout(event)">
                <span class="nav-icon-wrapper"><i class="bi bi-box-arrow-right"></i></span>
                Logout
            </button>
        </div>
    </aside>

    <!-- ========== TOP NAVBAR ========== -->
    <nav class="top-navbar">
        <div class="navbar-left">
            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <h4 class="page-title">
                @yield('page_title', 'Dashboard')
                <span>@yield('page_subtitle', '')</span>
            </h4>
        </div>

        <div class="navbar-right">
            <!-- Notification -->
            <div class="notification-wrapper">
                <button class="notification-btn" id="notificationBtn" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="notification-dot"></span>
                </button>

                <!-- Notification Dropdown - Real Data with Links -->
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-dropdown-header">
                        <h6>Notifications</h6>
                        @if($unreadCount > 0)
                            <a href="#" class="mark-all-read" id="markAllRead">Mark all as read</a>
                        @endif
                    </div>
                    <div class="notification-list">
                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <a href="{{ $notification->link ?? '#' }}" class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                                   data-id="{{ $notification->id }}"
                                   data-link="{{ $notification->link ?? '#' }}">
                                    <div class="notif-icon {{ $notification->type }}">
                                        <i class="{{ $notification->icon ?? ($notification->type == 'success' ? 'bi-check-circle' : ($notification->type == 'warning' ? 'bi-exclamation-triangle' : ($notification->type == 'error' ? 'bi-x-circle' : 'bi-info-circle'))) }}"></i>
                                    </div>
                                    <div class="notif-content">
                                        <p class="notif-title">{{ $notification->title }}</p>
                                        <p class="notif-text">{{ Str::limit($notification->message, 60) }}</p>
                                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(!$notification->is_read)
                                        <span class="notif-badge"></span>
                                    @endif
                                </a>
                            @endforeach
                        @else
                            <div class="notification-empty">
                                <i class="bi bi-bell-slash"></i>
                                <p>No notifications</p>
                            </div>
                        @endif
                    </div>
                    <div class="notification-dropdown-footer">
                        <a href="{{ route('notification') }}" class="view-all-btn">
                            <i class="bi bi-eye"></i> View All Notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="profile-wrapper">
                <button class="profile-btn" id="profileBtn" aria-label="Profile menu">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin+User' }}&background=4F46E5&color=fff&size=36" 
                         alt="Profile" class="profile-avatar">
                    <div class="profile-info">
                        <p class="name">{{ Auth::user()->name ?? 'Admin User' }}</p>
                        <p class="role">{{ Auth::user()->getRoleName() ?? 'Administrator' }}</p>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 12px; color: #94A3B8;"></i>
                </button>

                <!-- Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="bi bi-person-circle"></i> My Profile
                    </a>
                    <a href="{{ route('home') }}" class="dropdown-item">
                        <i class="bi bi-globe"></i> My Website
                    </a>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item text-danger" onclick="confirmLogout(event)">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="main-wrapper">
        @yield('content')
    </main>

    <!-- ========== SCRIPTS ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const hamburger = document.getElementById('hamburgerBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        hamburger.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Profile Dropdown
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
            // Close notification dropdown when opening profile
            document.getElementById('notificationDropdown').classList.remove('show');
        });

        document.addEventListener('click', () => {
            profileDropdown.classList.remove('show');
        });

        profileDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Notification Dropdown
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        notificationBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationDropdown.classList.toggle('show');
            // Close profile dropdown when opening notifications
            document.getElementById('profileDropdown').classList.remove('show');
        });

        document.addEventListener('click', () => {
            notificationDropdown.classList.remove('show');
        });

        notificationDropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Handle notification click - mark as read before navigating
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // If it's unread, mark it as read
                if (this.classList.contains('unread')) {
                    e.preventDefault(); // Prevent navigation until AJAX completes
                    
                    const notificationId = this.dataset.id;
                    const link = this.dataset.link;
                    
                    fetch(`/notifications/${notificationId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove unread styling
                            this.classList.remove('unread');
                            const badge = this.querySelector('.notif-badge');
                            if (badge) badge.remove();
                            
                            // Check if any unread remain
                            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
                            if (unreadCount === 0) {
                                document.querySelector('.notification-dot').style.display = 'none';
                                const sidebarBadge = document.querySelector('.nav-link-custom .nav-badge');
                                if (sidebarBadge) sidebarBadge.remove();
                                const markAllBtn = document.getElementById('markAllRead');
                                if (markAllBtn) markAllBtn.remove();
                            }
                            
                            // Navigate to the link
                            if (link && link !== '#') {
                                window.location.href = link;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Still navigate even if AJAX fails
                        if (link && link !== '#') {
                            window.location.href = link;
                        }
                    });
                } else {
                    // Already read, just navigate
                    const link = this.dataset.link;
                    if (link && link !== '#') {
                        window.location.href = link;
                    }
                }
            });
        });

        // Mark all as read - AJAX
        document.getElementById('markAllRead')?.addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('{{ route("notifications.mark-all-as-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove unread badges from all items
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        const badge = item.querySelector('.notif-badge');
                        if (badge) badge.remove();
                    });
                    // Hide the dot
                    document.querySelector('.notification-dot').style.display = 'none';
                    // Update sidebar badge
                    const sidebarBadge = document.querySelector('.nav-link-custom .nav-badge');
                    if (sidebarBadge) sidebarBadge.remove();
                    // Remove mark all read button
                    const markAllBtn = document.getElementById('markAllRead');
                    if (markAllBtn) markAllBtn.remove();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'All marked as read',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to mark all as read',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        });

        // Logout Confirmation
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the system",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#EF4444',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Auto-close sidebar on route change (for mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link-custom');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                    }
                });
            });
        });

        // Add active state to current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.nav-link-custom');
            
            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    const parentLi = link.closest('.nav-item');
                    if (parentLi) {
                        const siblings = parentLi.parentElement.querySelectorAll('.nav-item');
                        siblings.forEach(s => s.classList.remove('active'));
                        parentLi.classList.add('active');
                    }
                }
            });
        });
    </script>
</body>
</html>