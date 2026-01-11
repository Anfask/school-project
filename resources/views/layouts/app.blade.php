<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token Protection -->
    <x-csrf-protection />

    <title>@yield('title') - P.A. Inamdar School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .header-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
        .card-shadow {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            border-radius: 10px;
        }
        .required::after {
            content: " *";
            color: #dc3545;
        }
        .form-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        .section-title {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .nav-link:hover {
            opacity: 0.8;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .btn-link.nav-link {
            color: rgba(255,255,255,.55);
            padding: 0.5rem 0;
            margin-left: 1rem;
        }
        .btn-link.nav-link:hover {
            color: rgba(255,255,255,.75);
            text-decoration: none;
        }
    </style>

    <!-- CSRF Error Handling Styles -->
    <style>
        .csrf-error-alert {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #dc3545;
        }
        .csrf-error-alert i {
            margin-right: 10px;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark header-bg shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fas fa-graduation-cap me-2"></i>
                <span>P.A. Inamdar School</span>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            <span>Dashboard</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link d-flex align-items-center">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin.login') }}" class="nav-link d-flex align-items-center">
                            <i class="fas fa-lock me-2"></i>
                            <span>Admin Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- CSRF Error Messages -->
            @error('csrf_error')
                <div class="csrf-error-alert alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Session Expired!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror

            <!-- Success Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Info Messages -->
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Warning Messages -->
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <h5 class="mb-3">P.A. Inamdar English Medium School</h5>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Iqra Campus, Govindpura, Ahmednagar
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        info@painamdarschool.edu
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="mb-2">&copy; {{ date('Y') }} P.A. Inamdar English Medium School</p>
                    <p class="mb-0">All rights reserved.</p>
                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="text-white me-3">
                            <i class="fas fa-home"></i> Home
                        </a>
                        <a href="{{ route('admission.select') }}" class="text-white me-3">
                            <i class="fas fa-file-alt"></i> Admission
                        </a>
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="text-white">
                                <i class="fas fa-user-shield"></i> Admin
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- CSRF Token Management Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to refresh CSRF token
            function refreshCsrfToken() {
                return fetch('{{ route("csrf.refresh") }}')
                    .then(response => response.json())
                    .then(data => {
                        // Update all CSRF token inputs
                        document.querySelectorAll('input[name="_token"]').forEach(input => {
                            input.value = data.csrf_token;
                        });

                        // Update meta tag
                        const metaTag = document.querySelector('meta[name="csrf-token"]');
                        if (metaTag) {
                            metaTag.content = data.csrf_token;
                        }

                        // Update global variable
                        if (window.CSRF_TOKEN) {
                            window.CSRF_TOKEN = data.csrf_token;
                        }

                        console.log('CSRF token refreshed at:', data.timestamp);
                        return data.csrf_token;
                    })
                    .catch(error => {
                        console.error('Error refreshing CSRF token:', error);
                        return window.CSRF_TOKEN; // Return existing token
                    });
            }

            // Auto-refresh CSRF token every 30 minutes
            setInterval(() => {
                refreshCsrfToken();
            }, 30 * 60 * 1000); // 30 minutes

            // Refresh CSRF token on page load
            refreshCsrfToken();

            // Handle form submissions to validate CSRF token
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', async function(e) {
                    // Skip if it's a logout form (handled differently)
                    if (form.action.includes('logout')) {
                        return;
                    }

                    // Get the current CSRF token
                    const tokenInput = form.querySelector('input[name="_token"]');
                    if (!tokenInput) return;

                    const currentToken = tokenInput.value;

                    try {
                        // Validate the token before submission
                        const response = await fetch('{{ route("csrf.validate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': currentToken
                            },
                            body: JSON.stringify({ _token: currentToken })
                        });

                        const result = await response.json();

                        if (!result.valid) {
                            e.preventDefault();

                            // Refresh the token
                            const newToken = await refreshCsrfToken();

                            // Show error message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-warning alert-dismissible fade show';
                            alertDiv.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Your session has expired. The form has been refreshed. Please try submitting again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;

                            form.parentNode.insertBefore(alertDiv, form);

                            // Auto-dismiss after 5 seconds
                            setTimeout(() => {
                                if (alertDiv.parentNode) {
                                    alertDiv.remove();
                                }
                            }, 5000);
                        }
                    } catch (error) {
                        console.error('CSRF validation error:', error);
                    }
                });
            });

            // Handle logout button specially
            document.querySelectorAll('form[action*="logout"] button[type="submit"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('form');
                    const tokenInput = form.querySelector('input[name="_token"]');

                    if (tokenInput) {
                        // Store the token for logout
                        sessionStorage.setItem('logout_token', tokenInput.value);
                    }
                });
            });
        });
    </script>

    <!-- Page-specific scripts -->
    @yield('scripts')
</body>
</html>
