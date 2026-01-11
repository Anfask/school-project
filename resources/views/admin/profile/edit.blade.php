@extends('admin.layout')

@section('title', 'Profile Settings')

@section('content')
<div class="profile-container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-4 mb-4 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="fas fa-user-circle me-2 text-primary"></i>Profile Settings
            </h1>
            <p class="text-muted mb-0">Manage your account information and security</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-light text-dark me-3">
                <i class="fas fa-shield-alt me-1 text-success"></i>Secure
            </span>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#activityModal">
                <i class="fas fa-history"></i> Activity Log
            </button>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('status') == 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            Profile updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('status') == 'password-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            Password updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column: Profile Overview -->
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card profile-card mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <div class="avatar-wrapper">
                                @if(Auth::user()->profile_photo_path && Storage::disk('public')->exists(Auth::user()->profile_photo_path))
                                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                         alt="{{ Auth::user()->name }}"
                                         class="avatar-circle"
                                         style="object-fit: cover;">
                                @else
                                    <div class="avatar-circle bg-gradient-primary text-white">
                                        {{ Auth::user()->initials }}
                                    </div>
                                @endif
                                <button class="avatar-edit-btn" data-bs-toggle="modal" data-bs-target="#changePhotoModal">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>
                        <h3 class="mt-3 mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-user-tie me-1"></i>Administrator
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Active
                            </span>
                        </div>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Member Since</span>
                                <span class="stat-value">{{ Auth::user()->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Last Login</span>
                                <span class="stat-value">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">Account Status</span>
                                <span class="stat-value">Verified</span>
                            </div>
                        </div>
                        @if(Auth::user()->two_factor_enabled && Auth::user()->two_factor_confirmed_at)
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-shield-alt text-warning"></i>
                            </div>
                            <div class="stat-content">
                                <span class="stat-label">2FA Status</span>
                                <span class="stat-value">
                                    <span class="badge bg-success">Enabled</span>
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-action" data-bs-toggle="modal" data-bs-target="#twoFactorModal">
                            <i class="fas fa-mobile-alt me-2"></i>
                            @if(Auth::user()->two_factor_enabled && Auth::user()->two_factor_confirmed_at)
                                Manage 2FA
                            @else
                                Enable 2FA
                            @endif
                        </button>
                        <button class="btn btn-outline-info btn-action" data-bs-toggle="modal" data-bs-target="#backupCodesModal">
                            <i class="fas fa-key me-2"></i>Backup Codes
                        </button>
                        <button class="btn btn-outline-danger btn-action" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fas fa-trash-alt me-2"></i>Delete Account
                        </button>
                    </div>
                </div>
            </div>

            <!-- 2FA Status Card -->
            @if(Auth::user()->two_factor_enabled && Auth::user()->two_factor_confirmed_at)
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="fas fa-shield-alt me-2 text-success"></i>Security Status</h6>
                </div>
                <div class="card-body">
                    <div class="security-status">
                        <div class="security-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Two-Factor Authentication</span>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Strong Password</span>
                            <span class="badge bg-success">Secure</span>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span>Password Age</span>
                            <span class="badge bg-warning">
                                @if(Auth::user()->password_changed_at)
                                    {{ Auth::user()->password_changed_at->diffForHumans() }}
                                @else
                                    Never changed
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Forms -->
        <div class="col-lg-8">
            <!-- Profile Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon">
                            <i class="fas fa-user-edit text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Personal Information</h5>
                            <p class="text-muted mb-0 small">Update your basic profile details</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1 text-muted"></i>Full Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', Auth::user()->name) }}"
                                           placeholder="Enter your full name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1 text-muted"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', Auth::user()->email) }}"
                                           placeholder="Enter your email"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1 text-muted"></i>Phone Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                           placeholder="+1 (555) 123-4567">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="timezone" class="form-label">
                                    <i class="fas fa-globe me-1 text-muted"></i>Timezone
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <select class="form-select @error('timezone') is-invalid @enderror"
        id="timezone"
        name="timezone">
    <option value="Asia/Kolkata"
        {{ (Auth::user()->timezone ?? 'Asia/Kolkata') == 'Asia/Kolkata' ? 'selected' : '' }}>
        IST (India – New Delhi)
    </option>
</select>

                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="reset" class="btn btn-light me-2">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Security Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="header-icon">
                <i class="fas fa-lock text-warning"></i>
            </div>
            <div class="ms-3">
                <h5 class="mb-0">Security Settings</h5>
                <p class="text-muted mb-0 small">Manage your password and security preferences</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- IMPORTANT: Use POST method and remove @method('PATCH') -->
        <form method="POST" action="{{ route('profile.password.update') }}" class="needs-validation" novalidate>
            @csrf
            <!-- REMOVED: @method('PATCH') -->

            <div class="row g-3">
                <div class="col-md-12">
                    <label for="current_password" class="form-label">Current Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>
                        <input type="password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               id="current_password"
                               name="current_password"
                               placeholder="Enter current password"
                               required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Enter new password"
                               required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="password-strength mt-2">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" id="passwordStrength" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Password strength: <span id="strengthText">Weak</span></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Confirm new password"
                               required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="showPasswordRequirements">
                        <label class="form-check-label small text-muted" for="showPasswordRequirements">
                            Show password requirements
                        </label>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="password-requirements mt-3 d-none">
                <h6 class="small text-muted mb-2">Password must contain:</h6>
                <ul class="list-unstyled small text-muted">
                    <li class="requirement" data-rule="length">
                        <i class="fas fa-check-circle text-success me-1 d-none"></i>
                        <i class="fas fa-times-circle text-danger me-1"></i>
                        At least 8 characters
                    </li>
                    <li class="requirement" data-rule="uppercase">
                        <i class="fas fa-check-circle text-success me-1 d-none"></i>
                        <i class="fas fa-times-circle text-danger me-1"></i>
                        One uppercase letter
                    </li>
                    <li class="requirement" data-rule="lowercase">
                        <i class="fas fa-check-circle text-success me-1 d-none"></i>
                        <i class="fas fa-times-circle text-danger me-1"></i>
                        One lowercase letter
                    </li>
                    <li class="requirement" data-rule="number">
                        <i class="fas fa-check-circle text-success me-1 d-none"></i>
                        <i class="fas fa-times-circle text-danger me-1"></i>
                        One number
                    </li>
                </ul>
            </div>

            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key me-1"></i>Update Password
                </button>
            </div>
        </form>
    </div>
</div>
        </div>
    </div>
</div>

<!-- Include Modal Partials -->
@include('admin.profile.partials.modals.change-photo')
@include('admin.profile.partials.modals.delete-account')
@include('admin.profile.partials.modals.two-factor')
@include('admin.profile.partials.modals.backup-codes')
@include('admin.profile.partials.modals.activity-log')

@push('scripts')
<script>
$(document).ready(function() {
    // Password toggle functionality
    $('.toggle-password').click(function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Show/hide 2FA instructions based on selected method
    $('input[name="twoFactorMethod"]').change(function() {
        const method = $(this).val();
        $('#appInstructions, #smsInstructions').addClass('d-none');
        $(`#${method}Instructions`).removeClass('d-none');
    });

    // Initialize 2FA method display
    const initialMethod = $('input[name="twoFactorMethod"]:checked').val();
    if (initialMethod) {
        $(`#${initialMethod}Instructions`).removeClass('d-none');
    }

    // Password strength indicator
    $('#password').on('input', function() {
        updatePasswordStrength($(this).val());
    });

    // Password requirements toggle
    $('#showPasswordRequirements').change(function() {
        $('.password-requirements').toggleClass('d-none', !$(this).is(':checked'));
        if ($(this).is(':checked')) {
            updatePasswordRequirements($('#password').val());
        }
    });

    // Phone number formatting
    $('#phone').on('input', function(e) {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            value = '+' + value;
        }
        $(this).val(value);
    });

    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
});

// Password strength calculation
function updatePasswordStrength(password) {
    let strength = 0;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
    };

    // Calculate strength based on requirements met
    Object.values(requirements).forEach(met => {
        if (met) strength += 25;
    });

    // Cap at 100%
    strength = Math.min(strength, 100);

    // Update progress bar
    $('#passwordStrength').css('width', strength + '%');

    // Update strength text and color
    const strengthText = $('#strengthText');
    const progressBar = $('#passwordStrength');

    if (strength <= 25) {
        strengthText.text('Weak').removeClass().addClass('text-danger');
        progressBar.removeClass().addClass('progress-bar bg-danger');
    } else if (strength <= 50) {
        strengthText.text('Fair').removeClass().addClass('text-warning');
        progressBar.removeClass().addClass('progress-bar bg-warning');
    } else if (strength <= 75) {
        strengthText.text('Good').removeClass().addClass('text-info');
        progressBar.removeClass().addClass('progress-bar bg-info');
    } else {
        strengthText.text('Strong').removeClass().addClass('text-success');
        progressBar.removeClass().addClass('progress-bar bg-success');
    }

    // Update requirement checks
    updatePasswordRequirements(password);
}

// Update password requirement checks
function updatePasswordRequirements(password) {
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password)
    };

    Object.keys(requirements).forEach(rule => {
        const requirement = $(`.requirement[data-rule="${rule}"]`);
        const checkIcon = requirement.find('.fa-check-circle');
        const timesIcon = requirement.find('.fa-times-circle');

        if (requirements[rule]) {
            checkIcon.removeClass('d-none');
            timesIcon.addClass('d-none');
            requirement.addClass('text-success').removeClass('text-danger');
        } else {
            checkIcon.addClass('d-none');
            timesIcon.removeClass('d-none');
            requirement.addClass('text-danger').removeClass('text-success');
        }
    });
}

// Image preview for profile photo
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('photoPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">`;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Remove profile photo
function removePhoto() {
    if (!confirm('Are you sure you want to remove your profile photo?')) return;

    $.ajax({
        url: '{{ route("profile.photo.remove") }}',
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('#changePhotoModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                // Update avatar preview
                const preview = document.getElementById('photoPreview');
                preview.innerHTML = response.initials || '{{ Auth::user()->initials }}';

                // Update main avatar
                $('.avatar-wrapper .avatar-circle img').each(function() {
                    $(this).replaceWith(`<div class="avatar-circle bg-gradient-primary text-white">${response.initials || '{{ Auth::user()->initials }}'}</div>`);
                });

                showToast(response.message || 'Profile photo removed successfully!', 'success');
                $('#changePhotoModal').modal('hide');
            }
        },
        error: function(xhr) {
            showToast('Error removing photo. Please try again.', 'error');
        },
        complete: function() {
            $('#changePhotoModal .btn').prop('disabled', false);
        }
    });
}

// Upload photo function
function uploadPhoto() {
    const form = document.getElementById('photoForm');
    const formData = new FormData(form);

    // Validate file
    const fileInput = document.getElementById('profile_photo');
    if (!fileInput.files.length) {
        showToast('Please select an image file.', 'warning');
        return;
    }

    const file = fileInput.files[0];
    const fileSize = file.size / 1024 / 1024; // in MB
    if (fileSize > 2) {
        showToast('File size exceeds 2MB limit.', 'error');
        return;
    }

    // Check file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
        showToast('Invalid file type. Please use JPG, PNG, GIF, or WebP.', 'error');
        return;
    }

    $.ajax({
        url: '{{ route("profile.photo.upload") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('#changePhotoModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                // Update all avatars
                $('.avatar-circle').each(function() {
                    if ($(this).hasClass('bg-gradient-primary')) {
                        $(this).replaceWith(`<img src="${response.photo_url}" class="avatar-circle" style="object-fit: cover;">`);
                    } else {
                        $(this).attr('src', response.photo_url);
                    }
                });
                showToast(response.message || 'Profile photo updated successfully!', 'success');
                $('#changePhotoModal').modal('hide');
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                showToast(xhr.responseJSON.errors.profile_photo[0], 'error');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                showToast(xhr.responseJSON.message, 'error');
            } else {
                showToast('Error uploading photo. Please try again.', 'error');
            }
        },
        complete: function() {
            $('#changePhotoModal .btn').prop('disabled', false);
        }
    });
}

// Generate QR Code using Google Charts API
function generateQRCode(qrCodeUrl) {
    const container = $('#qrCodeContainer');
    container.empty();

    const size = 200;
    const encodedUrl = encodeURIComponent(qrCodeUrl);
    const googleChartsUrl = `https://chart.googleapis.com/chart?chs=${size}x${size}&cht=qr&chl=${encodedUrl}&choe=UTF-8`;

    // Create image element
    const img = document.createElement('img');
    img.src = googleChartsUrl;
    img.alt = 'QR Code';
    img.width = size;
    img.height = size;
    img.style.border = '1px solid #dee2e6';
    img.style.borderRadius = '8px';
    img.style.padding = '10px';
    img.style.background = 'white';

    // Add loading state
    container.html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin me-2"></i>Generating QR Code...</div>');

    img.onload = function() {
        container.empty().append(img);
    };

    img.onerror = function() {
        // Fallback to manual entry
        container.html(`
            <div class="text-center p-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    QR Code could not be generated. Please enter the secret manually.
                </div>
                <p class="text-muted small">Use manual entry in your authenticator app.</p>
            </div>
        `);
    };
}

// Enable 2FA
function enableTwoFactor() {
    const method = $('input[name="twoFactorMethod"]:checked').val();

    if (!method) {
        showToast('Please select a 2FA method.', 'warning');
        return;
    }

    $.ajax({
        url: '{{ route("profile.two-factor.enable") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            method: method
        },
        beforeSend: function() {
            $('#twoFactorModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                if (method === 'app') {
                    generateQRCode(response.qr_code_url);
                    $('#qrCodeModal #manualSecret').val(response.secret);
                    $('#twoFactorModal').modal('hide');
                    $('#qrCodeModal').modal('show');
                } else {
                    showToast('SMS verification would be implemented here.', 'info');
                }
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showToast(xhr.responseJSON.message, 'error');
            } else {
                showToast('Error enabling 2FA. Please try again.', 'error');
            }
        },
        complete: function() {
            $('#twoFactorModal .btn').prop('disabled', false);
        }
    });
}

// Copy secret to clipboard
function copySecret() {
    const secret = document.getElementById('manualSecret');
    secret.select();
    secret.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(secret.value).then(function() {
        showToast('Secret copied to clipboard!', 'success');
    }).catch(function() {
        showToast('Failed to copy secret.', 'error');
    });
}

// Verify 2FA code
function verifyTwoFactor() {
    const code = $('#verificationCode').val();

    if (!code || code.length !== 6 || !/^\d+$/.test(code)) {
        showToast('Please enter a valid 6-digit code.', 'warning');
        return;
    }

    $.ajax({
        url: '{{ route("profile.two-factor.confirm") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            code: code
        },
        beforeSend: function() {
            $('#qrCodeModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                $('#qrCodeModal').modal('hide');
                showBackupCodes(response.backup_codes);
                showToast(response.message || 'Two-factor authentication enabled successfully!', 'success');
                setTimeout(() => location.reload(), 2000);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                showToast(xhr.responseJSON?.message || 'Invalid verification code.', 'error');
            } else {
                showToast('Error verifying code. Please try again.', 'error');
            }
        },
        complete: function() {
            $('#qrCodeModal .btn').prop('disabled', false);
        }
    });
}

// Show backup codes
function showBackupCodes(codes) {
    let html = '<div class="alert alert-warning mb-3">';
    html += '<i class="fas fa-exclamation-triangle me-2"></i>';
    html += 'Save these backup codes in a secure location. Each code can be used only once.';
    html += '</div>';
    html += '<div class="text-center mb-3">';
    codes.forEach(code => {
        html += `<code class="d-block mb-2 p-2 bg-light rounded">${code}</code>`;
    });
    html += '</div>';
    html += '<div class="text-center">';
    html += '<button class="btn btn-warning btn-sm" onclick="downloadBackupCodes()">';
    html += '<i class="fas fa-download me-1"></i>Download Codes';
    html += '</button>';
    html += '</div>';

    $('#backupCodesList').html(html);
    $('#backupCodesModal').modal('show');
}

// Download backup codes
function downloadBackupCodes() {
    const userEmail = '{{ Auth::user()->email }}';
    const codes = {!! Auth::user()->two_factor_backup_codes ? json_encode(Auth::user()->two_factor_backup_codes) : '[]' !!};
    const content = `BACKUP CODES FOR: ${userEmail}
Generated on: ${new Date().toLocaleString()}

IMPORTANT:
• Each code can only be used ONCE
• Store these codes in a secure location
• Regenerate codes if you lose them

YOUR BACKUP CODES:
${codes.join('\n')}

SECURITY NOTES:
1. Keep this file secure and private
2. Do not share these codes with anyone
3. Delete this file after printing or saving securely`;

    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `backup-codes-${userEmail.replace(/[^a-z0-9]/gi, '-').toLowerCase()}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast('Backup codes downloaded!', 'success');
}

// Disable 2FA
function disableTwoFactor() {
    const password = $('#disablePassword').val();

    if (!password) {
        showToast('Please enter your password.', 'warning');
        return;
    }

    $.ajax({
        url: '{{ route("profile.two-factor.disable") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            password: password
        },
        beforeSend: function() {
            $('#disableTwoFactorModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                $('#disableTwoFactorModal').modal('hide');
                showToast('Two-factor authentication disabled.', 'success');
                setTimeout(() => location.reload(), 1500);
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                showToast('Invalid password. Please try again.', 'error');
            } else {
                showToast('Error disabling 2FA. Please try again.', 'error');
            }
        },
        complete: function() {
            $('#disableTwoFactorModal .btn').prop('disabled', false);
        }
    });
}

// Regenerate backup codes
function regenerateBackupCodes() {
    if (!confirm('This will invalidate your existing backup codes. Continue?')) return;

    $.ajax({
        url: '{{ route("profile.two-factor.regenerate-backup") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('#backupCodesModal .btn').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                showBackupCodes(response.backup_codes);
                showToast('Backup codes regenerated!', 'success');
            }
        },
        error: function(xhr) {
            showToast(xhr.responseJSON?.message || 'Error regenerating backup codes.', 'error');
        },
        complete: function() {
            $('#backupCodesModal .btn').prop('disabled', false);
        }
    });
}

// Confirm delete account
function confirmDelete() {
    const confirmText = document.getElementById('confirmDelete').value;
    const expectedText = 'DELETE {{ Auth::user()->email }}';
    const checkbox = document.getElementById('understandConsequences');

    if (confirmText !== expectedText) {
        showToast('Please type exactly: ' + expectedText, 'error');
        return;
    }

    if (!checkbox.checked) {
        showToast('Please confirm that you understand the consequences.', 'warning');
        return;
    }

    if (confirm('⚠️ FINAL WARNING ⚠️\n\nThis action is irreversible! Your account and all associated data will be permanently deleted.\n\nAre you absolutely sure?')) {
        document.getElementById('deleteAccountForm').submit();
    }
}

// Export activity log
function exportActivityLog() {
    showToast('Activity log export feature would be implemented here.', 'info');
}

// Toast notification function
function showToast(message, type = 'info') {
    // Remove any existing toasts
    $('.toast').remove();

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
    toast.setAttribute('role', 'alert');

    let icon = 'info-circle';
    if (type === 'success') icon = 'check-circle';
    if (type === 'error') icon = 'exclamation-circle';
    if (type === 'warning') icon = 'exclamation-triangle';

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-${icon} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 5000
    });
    bsToast.show();

    toast.addEventListener('hidden.bs.toast', function() {
        document.body.removeChild(toast);
    });
}

// Initialize tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<style>
.profile-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding: 20px;
}

.profile-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    background: white;
    transition: transform 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
}

.avatar-wrapper {
    position: relative;
    width: 140px;
    height: 140px;
    margin: 0 auto;
}

.avatar-circle {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: bold;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.05);
}

.avatar-edit-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #4e73df;
    color: white;
    border: 3px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.avatar-edit-btn:hover {
    background: #2e59d9;
    transform: scale(1.1) rotate(15deg);
}

.profile-stats {
    border-top: 1px solid #eee;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.2s ease;
}

.stat-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(78, 115, 223, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    transition: all 0.3s ease;
}

.stat-item:hover .stat-icon {
    transform: scale(1.1);
}

.stat-content {
    flex: 1;
}

.stat-label {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-value {
    display: block;
    font-weight: 600;
    color: #343a40;
    font-size: 1rem;
}

.btn-action {
    text-align: left;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    margin-bottom: 0.5rem;
}

.btn-action:hover {
    transform: translateX(10px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card-header .header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(78, 115, 223, 0.1) 0%, rgba(78, 115, 223, 0.2) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-strength .progress {
    background-color: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
}

.password-strength .progress-bar {
    border-radius: 10px;
    transition: width 0.3s ease, background-color 0.3s ease;
}

.password-requirements {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    padding: 1.25rem;
    border-left: 4px solid #4e73df;
}

.password-requirements li {
    margin-bottom: 0.75rem;
    padding: 0.25rem 0;
    display: flex;
    align-items: center;
}

.password-requirements i {
    font-size: 0.875rem;
    min-width: 20px;
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
    border-color: #dee2e6;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
}

.form-control.is-valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
}

/* Security Status */
.security-status {
    padding: 0;
    margin: 0;
}

.security-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.security-item:last-child {
    border-bottom: none;
}

.security-item i {
    min-width: 20px;
}

/* Toast animation */
.toast {
    animation: slideInRight 0.3s ease;
    z-index: 1060;
    min-width: 300px;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .profile-container {
        padding: 10px;
    }

    .avatar-wrapper {
        width: 120px;
        height: 120px;
    }

    .avatar-circle {
        font-size: 3rem;
    }

    .profile-stats {
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .btn-action {
        padding: 0.5rem;
        font-size: 0.9rem;
    }

    .card-header .header-icon {
        width: 36px;
        height: 36px;
    }

    .security-item {
        font-size: 0.9rem;
    }

    .toast {
        min-width: 250px;
        font-size: 0.875rem;
    }
}

/* Animation for stats */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-stats .stat-item {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.profile-stats .stat-item:nth-child(1) { animation-delay: 0.1s; }
.profile-stats .stat-item:nth-child(2) { animation-delay: 0.2s; }
.profile-stats .stat-item:nth-child(3) { animation-delay: 0.3s; }
.profile-stats .stat-item:nth-child(4) { animation-delay: 0.4s; }

/* Disabled button styles */
.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>
@endpush
@endsection
