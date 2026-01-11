@extends('layouts.app')

@section('title', 'Admission Form 3 - Higher Secondary')

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

        .subject-group-card {
            cursor: pointer;
            transition: all 0.2s;
        }

        .subject-group-card:hover {
            border-color: var(--primary-color) !important;
            background-color: rgba(67, 97, 238, 0.05);
        }

        .subject-group-card.selected {
            border-color: var(--primary-color) !important;
            background-color: rgba(67, 97, 238, 0.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
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
                            <i class="fas fa-file-alt me-1"></i> ADMISSION FORM 3 (11th & 12th)
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

                        <form action="{{ route('admission.form3.submit') }}" method="POST" enctype="multipart/form-data"
                            id="admissionForm" onsubmit="return validateAndSubmit()">
                            @csrf
                            <input type="hidden" name="academic_year" value="2026-2027">

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
                                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
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
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="student_name"
                                                        id="student_name" placeholder="Full Name"
                                                        value="{{ old('student_name') }}" required>
                                                    <label for="student_name">Student Full Name (Surname First)</label>
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
                                                        placeholder="DOB Words" value="{{ old('date_of_birth_words') }}"
                                                        required>
                                                    <label>Date of Birth (in Words)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="place_of_birth"
                                                        placeholder="Place" value="{{ old('place_of_birth') }}">
                                                    <label>Place of Birth</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="nationality"
                                                        value="{{ old('nationality', 'Indian') }}" required>
                                                    <label>Nationality</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="religion"
                                                        value="{{ old('religion') }}" required>
                                                    <label>Religion</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="caste"
                                                        value="{{ old('caste') }}" required>
                                                    <label>Caste</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="mother_tongue"
                                                        value="{{ old('mother_tongue') }}" required>
                                                    <label>Mother Tongue</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="place_of_birth"
                                                        placeholder="Place of Birth" value="{{ old('place_of_birth') }}"
                                                        >
                                                    <label>Place of Birth</label>
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
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="father_occupation"
                                                    value="{{ old('father_occupation') }}" required>
                                                <label>Occupation</label>
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
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="mother_occupation"
                                                    value="{{ old('mother_occupation') }}" required>
                                                <label>Occupation</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Contact & Address -->
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

                            <!-- 4. Academic Info -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-university"></i>Academic Details</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="last_school_attended"
                                                value="{{ old('last_school_attended') }}" required>
                                            <label>Last School Attended</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="admission_class" required>
                                                <option value="11th" selected>11th Standard</option>
                                            </select>
                                            <label>Admission Sought For</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject Groups -->
                                <div class="mt-4">
                                    <label class="form-label fw-bold mb-3">Select Stream / Subject Group <span
                                            class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        <!-- Arts (Groups A, B, C, D) -->
                                        <div class="col-12">
                                            <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-1 mb-2">Arts
                                                Stream</h6>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group A" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-primary">Group A</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>English, History</li>
                                                        <li>Pol. Sci, Education</li>
                                                        <li>EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group B" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-primary">Group B</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>English, History</li>
                                                        <li>Pol. Sci, Islamic St.</li>
                                                        <li>EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group C" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-primary">Group C</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>English, History</li>
                                                        <li>Education, Islamic St.</li>
                                                        <li>EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group D" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-primary">Group D</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>English, Pol. Sci</li>
                                                        <li>Education, Islamic St.</li>
                                                        <li>EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Science (Groups E, F, G, H) -->
                                        <div class="col-12 mt-3">
                                            <h6 class="text-muted small fw-bold text-uppercase border-bottom pb-1 mb-2">
                                                Science Stream</h6>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group E" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-success">Group E</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>Eng, Phy, Chem</li>
                                                        <li>Biology, EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group F" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-success">Group F</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>Eng, Phy, Chem</li>
                                                        <li>Biology, Maths</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group G" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-success">Group G</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>Eng, Phy, Chem</li>
                                                        <li>Maths, EVS</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="d-block h-100">
                                                <input type="radio" name="subject_group" value="Group H" class="d-none"
                                                    required onchange="highlightGroup(this)">
                                                <div class="card subject-group-card h-100 p-3">
                                                    <h6 class="fw-bold text-success">Group H</h6>
                                                    <ul class="small mb-0 ps-3 text-muted">
                                                        <li>Eng, Phy, Chem</li>
                                                        <li>Maths, IT</li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. ID Proofs -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-id-card"></i>ID & Documents</h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="aadhar_no"
                                                value="{{ old('aadhar_no') }}" required maxlength="12">
                                            <label>Aadhar Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" name="id_type" required>
                                                <option value="Aadhar">Aadhar Card</option>
                                                <option value="Passport">Passport</option>
                                                <option value="Birth Certificate">Birth Certificate</option>
                                            </select>
                                            <label>ID Document Type</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="id_number"
                                                value="{{ old('id_number') }}" required>
                                            <label>ID Document Number</label>
                                        </div>
                                    </div>

                                    <!-- Document Uploads -->
                                    <div class="col-12 mt-4">
                                        <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                            <i class="fas fa-info-circle me-2"></i><strong>Note:</strong> File size must be
                                            less than 2MB each. Allowed formats: JPG, PNG, PDF.
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-2 fw-bold small">Birth Certificate (Optional)</div>
                                        <input type="file" class="form-control form-control-sm" name="birth_certificate"
                                            onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2 fw-bold small">Leaving Certificate (Optional)</div>
                                        <input type="file" class="form-control form-control-sm" name="leaving_certificate"
                                            onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2 fw-bold small">Marksheet (Optional)</div>
                                        <input type="file" class="form-control form-control-sm" name="marksheet"
                                            onchange="validateFile(this)">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-2 fw-bold small">Caste Certificate (Optional)</div>
                                        <input type="file" class="form-control form-control-sm" name="caste_certificate"
                                            onchange="validateFile(this)">
                                    </div>
                                </div>
                            </div>

                            <!-- 6. Declaration -->
                            <div class="mb-5">
                                <h4 class="form-section-title"><i class="fas fa-check-double"></i>Declaration</h4>
                                <div class="card border-0 bg-light p-4 rounded-3">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="agree_declaration" id="agree1"
                                            required>
                                        <label class="form-check-label" for="agree1">
                                            I hereby declare that the information provided is true and correct to the best
                                            of my knowledge.
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
        // Visual feedback for group selection
        function highlightGroup(radio) {
            document.querySelectorAll('.subject-group-card').forEach(c => c.classList.remove('selected'));
            if (radio.checked) {
                radio.closest('label').querySelector('.subject-group-card').classList.add('selected');
            }
        }

        // Auto-generate DOB in words
        document.getElementById('date_of_birth').addEventListener('change', function () {
            const dateInput = this.value;
            if (dateInput) {
                const date = new Date(dateInput);
                const days = ['', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth',
                    'Eleventh', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth',
                    'Twenty-First', 'Twenty-Second', 'Twenty-Third', 'Twenty-Fourth', 'Twenty-Fifth', 'Twenty-Sixth', 'Twenty-Seventh', 'Twenty-Eighth', 'Twenty-Ninth', 'Thirtieth', 'Thirty-First'];

                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                const day = days[date.getDate()];
                const month = months[date.getMonth()];
                const year = convertNumberToWords(date.getFullYear());

                if (day && month && year) {
                    document.getElementsByName('date_of_birth_words')[0].value = `${day} ${month} ${year}`;
                }
            }
        });

        function convertNumberToWords(amount) {
            var words = new Array();
            words[0] = '';
            words[1] = 'One';
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';
            words[8] = 'Eight';
            words[9] = 'Nine';
            words[10] = 'Ten';
            words[11] = 'Eleven';
            words[12] = 'Twelve';
            words[13] = 'Thirteen';
            words[14] = 'Fourteen';
            words[15] = 'Fifteen';
            words[16] = 'Sixteen';
            words[17] = 'Seventeen';
            words[18] = 'Eighteen';
            words[19] = 'Nineteen';
            words[20] = 'Twenty';
            words[30] = 'Thirty';
            words[40] = 'Forty';
            words[50] = 'Fifty';
            words[60] = 'Sixty';
            words[70] = 'Seventy';
            words[80] = 'Eighty';
            words[90] = 'Ninety';
            amount = amount.toString();
            var atemp = amount.split(".");
            var number = atemp[0].split(",").join("");
            var n_length = number.length;
            var words_string = "";
            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }
                value = "";
                for (var i = 0; i < 9; i++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        value = n_array[i] * 10;
                    } else {
                        value = n_array[i];
                    }
                    if (value != 0) {
                        words_string += words[value] + " ";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Crores ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Lakhs ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Thousand ";
                    }
                    if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                        words_string += "Hundred and ";
                    } else if (i == 6 && value != 0) {
                        words_string += "Hundred ";
                    }
                }
                words_string = words_string.split("  ").join(" ");
            }
            return words_string;
        }

        // Client-side file validation
        function validateFile(input, previewId = null) {
            const file = input.files[0];
            if (!file) return;

            // Size check (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File is too large! Maximum allowed size is 2MB.');
                input.value = ''; // Clear input
                if (previewId) document.getElementById(previewId).style.display = 'none';
                return;
            }

            // Preview image if applicable
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

        // Submit handler
        function validateAndSubmit() {
            const btn = document.getElementById('btnSubmit');
            const overlay = document.getElementById('loadingOverlay');

            // Optional: Custom validation logic here if needed

            // Show loading state
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            overlay.style.display = 'flex';

            return true; // Proceed with submission
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection