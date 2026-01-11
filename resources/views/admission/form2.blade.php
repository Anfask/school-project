@extends('layouts.app')

@section('title', 'Admission Form 2 - Class 3 to 10')

@section('content')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-custom: #4cc9f0;
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: 1px solid rgba(255, 255, 255, 0.125);
            --shadow-premium: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .premium-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: var(--glass-border);
            box-shadow: var(--shadow-premium);
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .form-header {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2.5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .form-section-title {
            color: var(--primary-color);
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            background: rgba(67, 97, 238, 0.1);
            padding: 8px;
            border-radius: 8px;
            margin-right: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
            background: white;
        }

        .form-floating>label {
            padding-left: 1rem;
        }

        .btn-submit {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            letter-spacing: 0.5px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .photo-upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s;
            background: white;
        }

        .photo-upload-box:hover {
            border-color: var(--primary-color);
            background: #f8faff;
        }

        .preview-img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 10px;
            display: none;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Loading Spinner Overlay */
        #loadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c3cfe2;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #aab7d1;
        }
    </style>

    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-3 text-primary fw-bold">Submitting Application...</h5>
        <p class="text-muted">Please wait, do not refresh the page.</p>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="premium-card">
                    <!-- Header -->
                    <div class="form-header">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            style="height: 80px; margin-bottom: 15px; display: inline-block;">
                        <h2 class="fw-bold mb-1">Iqra Education & Welfare Society's</h2>
                        <h3 class="fw-bold mb-2">P.A. INAMIDAR ENGLISH MEDIUM SCHOOL</h3>
                        <div class="badge bg-white text-primary px-3 py-2 rounded-pill shadow-sm mt-2">
                            <i class="fas fa-file-alt me-1"></i> ADMISSION FORM 2 (Class 3 to 10)
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <!-- Error Alerts -->
                        @if($errors->any())
                            <div class="alert alert-danger shadow-sm border-0 border-start border-5 border-danger fade show p-4"
                                role="alert">
                                <h5 class="alert-heading fw-bold"><i class="fas fa-exclamation-circle me-2"></i>Submission
                                    Failed</h5>
                                <hr>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li class="mb-1">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admission.form2.submit') }}" method="POST" enctype="multipart/form-data"
                            id="admissionForm2" onsubmit="return validateAndSubmit()">
                            @csrf

                            <!-- 1. Student Information -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-user-graduate"></i>Student Information</h4>
                                <div class="row g-4">
                                    <!-- Photo Upload (Left Side) -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold required">Student Photo <span
                                                class="text-danger">*</span></label>
                                        <div class="photo-upload-box"
                                            onclick="document.getElementById('student_photo').click()">
                                            <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                                            <p class="small text-muted mb-0">Click to Upload</p>
                                            <p class="small text-muted" style="font-size: 0.75rem;">(Max 2MB)</p>
                                            <img id="preview_student_photo" class="preview-img mx-auto" />
                                        </div>
                                        <input type="file" name="student_photo" id="student_photo" class="d-none"
                                            accept="image/*" required
                                            onchange="validateFile(this, 'preview_student_photo')">
                                        @error('student_photo') <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Student Details (Right Side) -->
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="student_name"
                                                        id="student_name" placeholder="Full Name"
                                                        value="{{ old('student_name') }}" required>
                                                    <label for="student_name">Student Full Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" name="gender" id="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                    <label for="gender">Gender</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control" name="date_of_birth"
                                                        id="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                                    <label for="date_of_birth">Date of Birth</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="date_of_birth_words"
                                                        placeholder="In Words" value="{{ old('date_of_birth_words') }}"
                                                        required>
                                                    <label>Date of Birth (in Words)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="nationality"
                                                        value="{{ old('nationality', 'Indian') }}" required>
                                                    <label>Nationality</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select" name="religion" required>
                                                        <option value="">Select Religion</option>
                                                        <option value="Muslim" {{ old('religion') == 'Muslim' ? 'selected' : '' }}>Muslim</option>
                                                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                        <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                                        <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    <label>Religion</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="caste"
                                                        value="{{ old('caste') }}" required>
                                                    <label>Caste</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="mother_tongue"
                                                        value="{{ old('mother_tongue') }}" required>
                                                    <label>Mother Tongue</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Parents Information -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-users"></i>Parent Information</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 h-100 border">
                                            <h6 class="text-primary fw-bold mb-3">Father's Details</h6>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" name="father_name"
                                                    value="{{ old('father_name') }}" required>
                                                <label>Father's Name</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" name="father_occupation"
                                                    value="{{ old('father_occupation') }}" required>
                                                <label>Occupation</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="father_designation"
                                                    value="{{ old('father_designation') }}">
                                                <label>Designation (Optional)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3 h-100 border">
                                            <h6 class="text-primary fw-bold mb-3">Mother's Details</h6>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" name="mother_name"
                                                    value="{{ old('mother_name') }}" required>
                                                <label>Mother's Name</label>
                                            </div>
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" name="mother_occupation"
                                                    value="{{ old('mother_occupation') }}" required>
                                                <label>Occupation</label>
                                            </div>
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="mother_designation"
                                                    value="{{ old('mother_designation') }}">
                                                <label>Designation (Optional)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Address & Contact -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-map-marker-alt"></i>Address & Contact</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="present_address" style="height: 100px"
                                                required>{{ old('present_address') }}</textarea>
                                            <label>Present Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="permanent_address" style="height: 100px"
                                                required>{{ old('permanent_address') }}</textarea>
                                            <label>Permanent Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="pin_code"
                                                value="{{ old('pin_code') }}" required>
                                            <label>PIN Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" name="phone_no1"
                                                value="{{ old('phone_no1') }}" required maxlength="10">
                                            <label>Mobile No 1 (Parents)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" name="phone_no2"
                                                value="{{ old('phone_no2') }}" maxlength="10">
                                            <label>Mobile No 2 (Optional)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                                required>
                                            <label>Email Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. ID Proofs -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-id-card"></i>ID & Documents</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="aadhar_no"
                                                value="{{ old('aadhar_no') }}" required maxlength="12">
                                            <label>Aadhar Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="id_type" required>
                                                <option value="">Select ID Type</option>
                                                @foreach($idTypes as $idType)
                                                    <option value="{{ $idType }}" {{ old('id_type') == $idType ? 'selected' : '' }}>{{ $idType }}</option>
                                                @endforeach
                                            </select>
                                            <label>Other ID Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="id_number"
                                                value="{{ old('id_number') }}" required>
                                            <label>ID Document Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Academic Info -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-university"></i>To be Admitted</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="admission_class" required>
                                                <option value="">Select Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class }}" {{ old('admission_class') == $class ? 'selected' : '' }}>Class {{ $class }}</option>
                                                @endforeach
                                            </select>
                                            <label>Admission Sought For Class</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="academic_year" required>
                                                <option value="">Select Year</option>
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                <option value="{{ $currentYear }}-{{ $currentYear + 1 }}">
                                                    {{ $currentYear }}-{{ $currentYear + 1 }}</option>
                                                <option value="{{ $currentYear + 1 }}-{{ $currentYear + 2 }}">
                                                    {{ $currentYear + 1 }}-{{ $currentYear + 2 }}</option>
                                            </select>
                                            <label>Academic Year</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="last_school_attended"
                                                value="{{ old('last_school_attended') }}" required>
                                            <label>Last School Attended</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Document Uploads -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-folder-open"></i>Upload Documents</h4>
                                <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                    <i class="fas fa-info-circle me-2"></i><strong>Note:</strong> File size must be less
                                    than 2MB each. Allowed formats: JPG, PNG, PDF.
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Birth Certificate <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="birth_certificate"
                                            accept=".pdf,.jpg,.jpeg,.png" required onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Caste Certificate</label>
                                        <input type="file" class="form-control" name="caste_certificate"
                                            accept=".pdf,.jpg,.jpeg,.png" onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Leaving Certificate (Class 3+)</label>
                                        <input type="file" class="form-control" name="leaving_certificate"
                                            accept=".pdf,.jpg,.jpeg,.png" onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Previous Marksheet <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="marksheet"
                                            accept=".pdf,.jpg,.jpeg,.png" required onchange="validateFile(this)">
                                    </div>
                                </div>
                            </div>

                            <!-- 7. Declaration -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-file-signature"></i>Declaration</h4>
                                <div class="card border-0 bg-light p-4 rounded-3">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="agree_declaration" id="agree1"
                                            required>
                                        <label class="form-check-label" for="agree1">
                                            I hereby declare that the information provided is true and correct.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agreed_to_rules" id="agree2"
                                            required>
                                        <label class="form-check-label" for="agree2">
                                            I agree to abide by the school rules and regulations.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Captcha -->
                            <div class="mb-4 text-center">
                                <div class="g-recaptcha d-inline-block" data-sitekey="{{ config('captcha.site_key') }}">
                                </div>
                                @error('g-recaptcha-response') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-submit text-white shadow" id="btnSubmit">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Application
                                </button>
                                <div class="mt-3">
                                    <a href="{{ route('home') }}" class="text-muted text-decoration-none small"><i
                                            class="fas fa-arrow-left me-1"></i>Back to Home</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateFile(input, previewId = null) {
            const file = input.files[0];
            if (!file) return;

            // Size check (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File is too large! Maximum allowed size is 2MB.');
                input.value = '';
                if (previewId) document.getElementById(previewId).src = '';
                return;
            }

            // Preview
            if (previewId && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        function validateAndSubmit() {
            const btn = document.getElementById('btnSubmit');
            const overlay = document.getElementById('loadingOverlay');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            overlay.style.display = 'flex';
            return true;
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection