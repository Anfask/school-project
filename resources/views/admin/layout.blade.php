<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Pusher for realtime -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #7209b7;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-width: 250px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: #333;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 20px 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 0 30px rgba(67, 97, 238, 0.15);
        }

        .sidebar .logo {
            padding: 0 20px;
            margin-bottom: 30px;
        }

        .sidebar .logo a {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .logo a i {
            font-size: 28px;
        }

        .sidebar .nav-links {
            list-style: none;
            padding: 0;
        }

        .sidebar .nav-links li {
            margin: 5px 0;
        }

        .sidebar .nav-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 0 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-links a:hover,
        .sidebar .nav-links a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-links a i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Topbar */
        .topbar {
            height: var(--header-height);
            background: white;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar .page-title h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: var(--dark-color);
        }

        .topbar .page-title p {
            color: #6c757d;
            margin: 0;
            font-size: 14px;
        }

        .topbar .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar .user-menu .notifications {
            position: relative;
        }

        .topbar .user-menu .notifications .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar .user-menu .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .topbar .user-menu .user-profile .profile-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .topbar .user-menu .user-profile .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .topbar .user-menu .user-profile .user-info h6 {
            margin: 0;
            font-weight: 600;
        }

        .topbar .user-menu .user-profile .user-info small {
            color: #6c757d;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            border-radius: 15px 15px 0 0 !important;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 25px;
        }

        /* Stats Cards */
        .stat-card {
            border-radius: 15px;
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .stat-card .count {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card .label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        .stat-card.todo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.in-progress {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.done {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.total {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        /* Notification Dropdown */
        .notification-dropdown {
            width: 350px;
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s ease;
        }

        .notification-item:hover {
            background: #f8f9fa;
        }

        .notification-item.unread {
            background: #f0f7ff;
        }

        .notification-item .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .notification-item .notification-content {
            flex: 1;
        }

        .notification-item .notification-time {
            font-size: 11px;
            color: #6c757d;
        }

        .notification-item .notification-actions {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .notification-item:hover .notification-actions {
            opacity: 1;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            width: 250px;
        }

        .profile-dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            text-align: center;
        }

        .profile-dropdown-header .profile-image-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 10px;
            overflow: hidden;
            border: 3px solid var(--primary-color);
        }

        .profile-dropdown-header .profile-image-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success-color);
        }

        .btn-danger {
            background: var(--danger-color);
        }

        .btn-warning {
            background: var(--warning-color);
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 12px;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        /* Tables */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        /* Online Status Indicator */
        .online-status {
            position: relative;
            display: inline-block;
        }

        .online-status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .online-status-indicator.online {
            background: #28a745;
        }

        .online-status-indicator.offline {
            background: #6c757d;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .notification-dropdown {
                width: 300px;
            }
        }

        @media (max-width: 576px) {
            .notification-dropdown {
                width: 280px;
            }

            .topbar {
                padding: 0 15px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        .pulse {
            animation: pulse 1s ease infinite;
        }

        /* Notification Sound */
        .notification-sound {
            display: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            background: transparent;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            color: var(--primary-color);
        }

        [data-bs-theme="dark"] .topbar {
            background: #1a1d23;
        }

        [data-bs-theme="dark"] body {
            background-color: #12141a;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .card {
            background: #1a1d23;
            color: #e9ecef;
        }

        [data-bs-theme="dark"] .card-header {
            background: #1a1d23;
            border-color: #2d3748;
        }

        [data-bs-theme="dark"] .notification-item:hover {
            background: #2d3748;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <span>YES ADMISSION</span>
            </a>
        </div>

        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.applications') }}"
                    class="{{ request()->routeIs('admin.applications') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Applications</span>
                    @php
                        $pendingCount = App\Models\AdmissionQuery::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-warning ms-auto pulse" id="pendingApplicationsBadge">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.statistics') }}"
                    class="{{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Statistics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="mt-4">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="page-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Welcome back, ' . auth()->user()->name . '!')</p>
            </div>

            <div class="user-menu">
                <!-- Theme Toggle -->
                <button class="btn theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>

                <!-- Notifications -->
                <div class="notifications dropdown">
                    <a href="#" class="btn btn-light btn-sm" data-bs-toggle="dropdown" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger" id="notificationCount">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <h6 class="dropdown-header d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <button class="btn btn-sm btn-link p-0" id="markAllAsRead">
                                    Mark all as read
                                </button>
                            @endif
                        </h6>
                        <div id="notificationsList">
                            @forelse(auth()->user()->notifications()->take(10)->get() as $notification)
                                <div class="notification-item {{ $notification->unread() ? 'unread' : '' }}"
                                    data-notification-id="{{ $notification->id }}">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="notification-icon
                                            @if($notification->data['type'] == 'success') bg-success
                                            @elseif($notification->data['type'] == 'warning') bg-warning
                                            @elseif($notification->data['type'] == 'error') bg-danger
                                            @else bg-primary @endif">
                                            @if($notification->data['type'] == 'success')
                                                <i class="fas fa-check"></i>
                                            @elseif($notification->data['type'] == 'warning')
                                                <i class="fas fa-exclamation"></i>
                                            @elseif($notification->data['type'] == 'error')
                                                <i class="fas fa-times"></i>
                                            @else
                                                <i class="fas fa-info"></i>
                                            @endif
                                        </div>
                                        <div class="notification-content flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $notification->data['subject'] ?? 'Notification' }}</strong>
                                                <small class="notification-time">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <p class="mb-1" style="font-size: 13px;">
                                                {{ Str::limit($notification->data['message'] ?? '', 60) }}
                                            </p>
                                            @if(isset($notification->data['action_url']))
                                                <a href="{{ $notification->data['action_url'] }}"
                                                    class="btn btn-sm btn-outline-primary btn-xs mt-1">
                                                    View Details
                                                </a>
                                            @endif
                                        </div>
                                        <div class="notification-actions">
                                            @if($notification->unread())
                                                <button class="btn btn-sm btn-link text-success mark-as-read"
                                                    data-id="{{ $notification->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-link text-danger delete-notification"
                                                data-id="{{ $notification->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3">
                                    <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">No notifications</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="{{ route('admin.notifications.index') }}">
                            View all notifications
                        </a>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="user-profile dropdown">
                    <div data-bs-toggle="dropdown">
                        <div class="d-flex align-items-center gap-2">
                            <div class="online-status">
                                <div class="profile-avatar">
                                    @if(auth()->user()->profile_photo_url)
                                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                                            onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"
                                            http://www.w3.org/2000/svg\" width=\"40\" height=\"40\" viewBox=\"0 0 40 40\">
                                        <rect width=\"40\" height=\"40\" fill=\"%234361ee\" /><text x=\"50%\" y=\"50%\"
                                            dy=\".3em\" fill=\"white\" text-anchor=\"middle\" font-size=\"16\">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</text></svg>'">
                                    @else
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <span class="online-status-indicator online"></span>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                            </div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <div class="profile-dropdown-header">
                            <div class="profile-image-large">
                                @if(auth()->user()->profile_photo_url)
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                                        onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\"
                                        http://www.w3.org/2000/svg\" width=\"80\" height=\"80\" viewBox=\"0 0 80 80\">
                                    <rect width=\"80\" height=\"80\" fill=\"%234361ee\" /><text x=\"50%\" y=\"50%\"
                                        dy=\".3em\" fill=\"white\" text-anchor=\"middle\" font-size=\"32\">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</text></svg>'">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100"
                                        style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; font-size: 32px; font-weight: bold;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}#security">
                            <i class="fas fa-shield-alt me-2"></i> Security
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Notification Sound -->


    <!-- Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-dismiss alerts
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Mobile menu toggle
            const mobileMenuBtn = document.createElement('button');
            mobileMenuBtn.className = 'btn btn-primary mobile-menu-btn d-lg-none';
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            mobileMenuBtn.style.position = 'fixed';
            mobileMenuBtn.style.top = '15px';
            mobileMenuBtn.style.left = '15px';
            mobileMenuBtn.style.zIndex = '1001';
            mobileMenuBtn.addEventListener('click', function () {
                document.querySelector('.sidebar').classList.toggle('active');
            });
            document.body.appendChild(mobileMenuBtn);

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (e) {
                const sidebar = document.querySelector('.sidebar');
                const mobileBtn = document.querySelector('.mobile-menu-btn');
                if (window.innerWidth < 992 &&
                    !sidebar.contains(e.target) &&
                    !mobileBtn.contains(e.target) &&
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });

            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            const currentTheme = localStorage.getItem('theme') || 'light';

            if (currentTheme === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }

            themeToggle.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                if (currentTheme === 'dark') {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    localStorage.setItem('theme', 'light');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                }
            });

            // Notification handling
            const notificationSound = document.getElementById('notificationSound');

            // Mark notification as read
            $(document).on('click', '.mark-as-read', function () {
                const notificationId = $(this).data('id');
                const notificationItem = $(this).closest('.notification-item');

                $.ajax({
                    url: '/admin/notifications/' + notificationId + '/read',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        notificationItem.removeClass('unread');
                        updateNotificationCount();
                    }
                });
            });

            // Delete notification
            $(document).on('click', '.delete-notification', function () {
                const notificationId = $(this).data('id');
                const notificationItem = $(this).closest('.notification-item');

                $.ajax({
                    url: '/admin/notifications/' + notificationId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        notificationItem.remove();
                        updateNotificationCount();
                    }
                });
            });

            // Mark all as read
            $('#markAllAsRead').click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/admin/notifications/mark-all-read',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('.notification-item').removeClass('unread');
                        updateNotificationCount();
                    }
                });
            });

            function updateNotificationCount() {
                const unreadCount = $('.notification-item.unread').length;
                $('#notificationCount').text(unreadCount);

                if (unreadCount === 0) {
                    $('#notificationCount').hide();
                } else {
                    $('#notificationCount').show();
                }
            }

            // Global AJAX setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize real-time notifications (Pusher)
            initializeRealtimeNotifications();
        });

        function initializeRealtimeNotifications() {
            // Check if Pusher is available
            if (typeof Pusher === 'undefined') {
                console.log('Pusher not loaded');
                return;
            }

            // Enable pusher logging - don't include this in production
            // Pusher.logToConsole = true;

            // Initialize Pusher with your credentials
            const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
                cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
                encrypted: true
            });

            // Subscribe to the user's private channel
            const channel = pusher.subscribe('private-user.{{ auth()->id() }}');

            // Listen for new notification events
            channel.bind('notification.received', function (data) {
                console.log('New notification received:', data);



                // Update notification count
                const countElement = document.getElementById('notificationCount');
                let currentCount = parseInt(countElement.textContent) || 0;
                countElement.textContent = currentCount + 1;
                countElement.style.display = 'flex';

                // Add notification to dropdown
                addNotificationToDropdown(data.notification);

                // Update pending applications badge if it's a new application
                if (data.notification.type === 'new_application') {
                    updatePendingApplicationsCount();
                }

                // Show desktop notification if browser supports it
                if ("Notification" in window && Notification.permission === "granted") {
                    new Notification(data.notification.subject, {
                        body: data.notification.message,
                        icon: '/favicon.ico'
                    });
                }

                // Animate the notification bell
                const bell = document.getElementById('notificationBell');
                bell.classList.add('pulse');
                setTimeout(() => bell.classList.remove('pulse'), 1000);
            });

            // Listen for application status updates
            channel.bind('application.updated', function (data) {
                console.log('Application updated:', data);
                updatePendingApplicationsCount();
            });

            // Request notification permission
            if ("Notification" in window && Notification.permission === "default") {
                Notification.requestPermission();
            }
        }

        function addNotificationToDropdown(notification) {
            const notificationsList = document.getElementById('notificationsList');

            // Create notification item
            const notificationItem = document.createElement('div');
            notificationItem.className = 'notification-item unread';
            notificationItem.setAttribute('data-notification-id', notification.id);

            const iconClass = notification.type === 'success' ? 'bg-success' :
                notification.type === 'warning' ? 'bg-warning' :
                    notification.type === 'error' ? 'bg-danger' : 'bg-primary';

            const iconIcon = notification.type === 'success' ? 'fa-check' :
                notification.type === 'warning' ? 'fa-exclamation' :
                    notification.type === 'error' ? 'fa-times' : 'fa-info';

            notificationItem.innerHTML = `
                <div class="d-flex align-items-start gap-3">
                    <div class="notification-icon ${iconClass}">
                        <i class="fas ${iconIcon}"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong>${notification.subject || 'Notification'}</strong>
                            <small class="notification-time">Just now</small>
                        </div>
                        <p class="mb-1" style="font-size: 13px;">
                            ${notification.message ? notification.message.substring(0, 60) + (notification.message.length > 60 ? '...' : '') : ''}
                        </p>
                        ${notification.action_url ? `
                        <a href="${notification.action_url}" class="btn btn-sm btn-outline-primary btn-xs mt-1">
                            View Details
                        </a>
                        ` : ''}
                    </div>
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-link text-success mark-as-read" data-id="${notification.id}">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-sm btn-link text-danger delete-notification" data-id="${notification.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            // Add to top of list
            if (notificationsList.firstChild) {
                notificationsList.insertBefore(notificationItem, notificationsList.firstChild);
            } else {
                notificationsList.appendChild(notificationItem);
            }

            // Remove "no notifications" message if present
            const noNotifications = notificationsList.querySelector('.text-center');
            if (noNotifications) {
                noNotifications.remove();
            }
        }

        function updatePendingApplicationsCount() {
            $.ajax({
                url: '{{ route("admin.applications.count.pending") }}',
                method: 'GET',
                success: function (response) {
                    const badge = document.getElementById('pendingApplicationsBadge');
                    if (badge) {
                        badge.textContent = response.count;
                        if (response.count > 0) {
                            badge.classList.add('pulse');
                        } else {
                            badge.classList.remove('pulse');
                        }
                    }
                }
            });
        }

        // Update pending applications count every 30 seconds
        setInterval(updatePendingApplicationsCount, 30000);
    </script>

    @stack('scripts')
</body>

</html>