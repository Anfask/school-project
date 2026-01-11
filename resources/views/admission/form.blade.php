@extends('layouts.app')

@section('title', 'Admission Form')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header with School Logo -->
                <div class="card-header text-center bg-gradient-primary text-white py-4 rounded-top-4">
                    <div class="school-header mb-3">
                        <h2 class="mb-1 fw-bold">Iqra Education & Welfare Society's</h2>
                        <h3 class="mb-1">P.A. INAMIDAR ENGLISH MEDIUM SCHOOL (Primary)</h3>
                        <h4 class="mb-0">APPLICATION FOR ADMISSION</h4>
                    </div>
                    <p class="mb-0"><small>Academic Year: {{ $academicYear ?? date('Y') . '-' . (date('Y') + 1) }}</small></p>
                </div>

                <div class="card-body p-4">
                    <!-- Progress Indicator -->
                    <div class="progress mb-5 shadow-sm" style="height: 8px;">
                        <div class="progress-bar bg-gradient progress-bar-animated" role="progressbar" style="width: 0%" id="formProgress"></div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <h5 class="alert-heading d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                            </h5>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admission.submit') }}" method="POST" enctype="multipart/form-data" id="admissionForm">
                        @csrf

                        <!-- Section 1: Student Photograph -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">1</span>
                                    <span><i class="fas fa-camera me-2"></i>Student Photograph</span>
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label class="form-label required fw-semibold">Passport Size Photograph</label>
                                        <div class="input-group shadow-sm">
                                            <input type="file" class="form-control @error('passport_photo') is-invalid @enderror"
                                                   name="passport_photo" id="passport_photo" accept="image/*" required
                                                   onchange="previewImage(this)">
                                            <label class="input-group-text bg-primary text-white" for="passport_photo">
                                                <i class="fas fa-camera"></i>
                                            </label>
                                        </div>
                                        @error('passport_photo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle text-primary me-1"></i>
                                            Recent passport size photograph (JPG/PNG, max 2MB). Clear face visible without glasses.
                                        </div>
                                    </div>

                                    <div class="image-requirements bg-gradient-light p-3 rounded-3 border shadow-sm">
                                        <h6 class="mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i>Photo Requirements:</h6>
                                        <ul class="mb-0 small">
                                            <li>Recent color photograph (taken within last 3 months)</li>
                                            <li>Plain white or light-colored background</li>
                                            <li>Face covering 70-80% of the photograph</li>
                                            <li>Front view with both ears visible</li>
                                            <li>Neutral expression with both eyes open</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="photo-preview-container text-center">
                                        <div class="photo-preview border rounded-3 p-3 bg-light mb-3 shadow">
                                            <img id="photoPreview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='250' viewBox='0 0 200 250'%3E%3Crect width='200' height='250' fill='%23f8f9fa' stroke='%23dee2e6' stroke-width='2'/%3E%3Ctext x='100' y='120' text-anchor='middle' font-family='Arial' font-size='14' fill='%236c757d'%3EPassport Photo%3C/text%3E%3Ctext x='100' y='140' text-anchor='middle' font-family='Arial' font-size='12' fill='%236c757d'%3EPreview%3C/text%3E%3C/svg%3E"
                                                 alt="Photo Preview" class="img-fluid rounded-3">
                                        </div>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-ruler-combined me-1"></i>
                                            Required Size: 2.5 x 3.0 cm
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Student Information -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">2</span>
                                    <span><i class="fas fa-user-graduate me-2"></i>Student Information</span>
                                </h5>
                            </div>

                            <div class="row g-3">
                                <!-- Student Name -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('surname') is-invalid @enderror"
                                               name="surname" id="surname" placeholder="Enter surname"
                                               value="{{ old('surname') }}" required>
                                        <label for="surname" class="required">Surname / Last Name</label>
                                        @error('surname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                               name="first_name" id="first_name" placeholder="Enter first name"
                                               value="{{ old('first_name') }}" required>
                                        <label for="first_name" class="required">First Name</label>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Gender Field (NEW) -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <select class="form-select @error('gender') is-invalid @enderror"
                                                name="gender" id="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <label for="gender" class="required"><i class="fas fa-venus-mars me-2"></i>Gender</label>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                               name="date_of_birth" id="date_of_birth" placeholder="Date of Birth"
                                               value="{{ old('date_of_birth') }}" required>
                                        <label for="date_of_birth" class="required">Date of Birth</label>
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-birthday-cake text-primary me-1"></i>
                                        Student must be between 3 to 12 years old
                                    </div>
                                </div>

                                <!-- Place of Birth -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                               name="place_of_birth" id="place_of_birth" placeholder="Place of Birth"
                                               value="{{ old('place_of_birth') }}" required>
                                        <label for="place_of_birth" class="required">Place of Birth</label>
                                        @error('place_of_birth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Personal Details -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <select class="form-select @error('religion') is-invalid @enderror"
                                                name="religion" id="religion" required>
                                            <option value="">Select Religion</option>
                                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>Christian</option>
                                            <option value="Sikh" {{ old('religion') == 'Sikh' ? 'selected' : '' }}>Sikh</option>
                                            <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>Buddhist</option>
                                            <option value="Jain" {{ old('religion') == 'Jain' ? 'selected' : '' }}>Jain</option>
                                            <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <label for="religion" class="required">Religion</label>
                                        @error('religion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('caste') is-invalid @enderror"
                                               name="caste" id="caste" placeholder="Caste"
                                               value="{{ old('caste') }}" required>
                                        <label for="caste" class="required">Caste</label>
                                        @error('caste')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                               name="nationality" id="nationality" placeholder="Nationality"
                                               value="{{ old('nationality') }}" required>
                                        <label for="nationality" class="required">Nationality</label>
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Physical Fitness -->
                                <div class="col-12">
                                    <div class="form-check form-switch p-3 bg-light rounded-3 shadow-sm">
                                        <input class="form-check-input @error('is_physically_unfit') is-invalid @enderror"
                                               type="checkbox" name="is_physically_unfit" value="1"
                                               id="physically_unfit" {{ old('is_physically_unfit') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="physically_unfit">
                                            <i class="fas fa-wheelchair text-primary me-2"></i>
                                            Is the child physically unfit? If yes, please provide details
                                        </label>
                                        @error('is_physically_unfit')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Parent/Guardian Information -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">3</span>
                                    <span><i class="fas fa-users me-2"></i>Parent/Guardian Information</span>
                                </h5>
                            </div>

                            <div class="row g-3">
                                <!-- Father's Information -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('father_full_name') is-invalid @enderror"
                                               name="father_full_name" id="father_full_name" placeholder="Father's Full Name"
                                               value="{{ old('father_full_name') }}" required>
                                        <label for="father_full_name" class="required">Father's Full Name</label>
                                        @error('father_full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Mother's Information -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('mother_full_name') is-invalid @enderror"
                                               name="mother_full_name" id="mother_full_name" placeholder="Mother's Full Name"
                                               value="{{ old('mother_full_name') }}" required>
                                        <label for="mother_full_name" class="required">Mother's Full Name</label>
                                        @error('mother_full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Guardian's Information -->
                                <div class="col-12">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('parents_guardian_full_name') is-invalid @enderror"
                                               name="parents_guardian_full_name" id="parents_guardian_full_name"
                                               placeholder="Parents/Guardian's Full Name"
                                               value="{{ old('parents_guardian_full_name') }}" required>
                                        <label for="parents_guardian_full_name" class="required">
                                            Parents/Guardian's Full Name
                                        </label>
                                        @error('parents_guardian_full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle text-primary me-1"></i>
                                            If different from parents, please provide guardian's name
                                        </div>
                                    </div>
                                </div>

                                <!-- Local Address -->
                                <div class="col-12">
                                    <div class="form-floating shadow-sm">
                                        <textarea class="form-control @error('local_address') is-invalid @enderror"
                                                  name="local_address" id="local_address" placeholder="Local Address"
                                                  style="height: 100px" required>{{ old('local_address') }}</textarea>
                                        <label for="local_address" class="required">Local Address (Residential)</label>
                                        @error('local_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="tel" class="form-control @error('mobile_1') is-invalid @enderror"
                                               name="mobile_1" id="mobile_1" placeholder="Mobile Number 1"
                                               value="{{ old('mobile_1') }}" required>
                                        <label for="mobile_1" class="required">
                                            <i class="fas fa-mobile-alt me-2"></i>Mobile Number 1
                                        </label>
                                        @error('mobile_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="tel" class="form-control @error('mobile_2') is-invalid @enderror"
                                               name="mobile_2" id="mobile_2" placeholder="Mobile Number 2 (Optional)"
                                               value="{{ old('mobile_2') }}">
                                        <label for="mobile_2">
                                            <i class="fas fa-mobile-alt me-2"></i>Mobile Number 2 (Optional)
                                        </label>
                                        @error('mobile_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12">
                                    <div class="form-floating shadow-sm">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email" id="email" placeholder="Email Address"
                                               value="{{ old('email') }}" required>
                                        <label for="email" class="required">
                                            <i class="fas fa-envelope me-2"></i>Email Address
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle text-primary me-1"></i>
                                            All communication will be sent to this email address
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Educational Background -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">4</span>
                                    <span><i class="fas fa-book me-2"></i>Educational Background</span>
                                </h5>
                            </div>

                            <div class="row g-3">
                                <!-- Last School Information -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('last_school_attended') is-invalid @enderror"
                                               name="last_school_attended" id="last_school_attended"
                                               placeholder="Last School Attended"
                                               value="{{ old('last_school_attended') }}">
                                        <label for="last_school_attended">
                                            Last School Attended (If any)
                                        </label>
                                        @error('last_school_attended')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <input type="text" class="form-control @error('studying_in_std') is-invalid @enderror"
                                               name="studying_in_std" id="studying_in_std"
                                               placeholder="Currently Studying in Class"
                                               value="{{ old('studying_in_std') }}">
                                        <label for="studying_in_std">
                                            Currently Studying in Class
                                        </label>
                                        @error('studying_in_std')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- School Address -->
                                <div class="col-12">
                                    <div class="form-floating shadow-sm">
                                        <textarea class="form-control @error('last_school_address') is-invalid @enderror"
                                                  name="last_school_address" id="last_school_address"
                                                  placeholder="Last School Address"
                                                  style="height: 80px">{{ old('last_school_address') }}</textarea>
                                        <label for="last_school_address">Last School Address</label>
                                        @error('last_school_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Medium of Instruction -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <select class="form-select @error('medium_of_instruction') is-invalid @enderror"
                                                name="medium_of_instruction" id="medium_of_instruction">
                                            <option value="">Select Medium of Instruction</option>
                                            <option value="English" {{ old('medium_of_instruction') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Hindi" {{ old('medium_of_instruction') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                            <option value="Marathi" {{ old('medium_of_instruction') == 'Marathi' ? 'selected' : '' }}>Marathi</option>
                                            <option value="Urdu" {{ old('medium_of_instruction') == 'Urdu' ? 'selected' : '' }}>Urdu</option>
                                            <option value="Other" {{ old('medium_of_instruction') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        <label for="medium_of_instruction">Medium of Instruction</label>
                                        @error('medium_of_instruction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Admission Details -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">5</span>
                                    <span><i class="fas fa-clipboard-list me-2"></i>Admission Details</span>
                                </h5>
                            </div>

                            <div class="row g-3">
                                <!-- Class Selection -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <select class="form-select @error('admission_sought_for_class') is-invalid @enderror"
                                                name="admission_sought_for_class" id="admission_sought_for_class" required>
                                            <option value="">Select Class</option>
                                            <option value="Nursery" {{ old('admission_sought_for_class') == 'Nursery' ? 'selected' : '' }}>Nursery</option>
                                            <option value="Jr.KG" {{ old('admission_sought_for_class') == 'Jr.KG' ? 'selected' : '' }}>Jr. KG (LKG)</option>
                                            <option value="Sr.KG" {{ old('admission_sought_for_class') == 'Sr.KG' ? 'selected' : '' }}>Sr. KG (UKG)</option>
                                            <option value="1st" {{ old('admission_sought_for_class') == '1st' ? 'selected' : '' }}>1st Standard</option>
                                            <option value="2nd" {{ old('admission_sought_for_class') == '2nd' ? 'selected' : '' }}>2nd Standard</option>
                                            <option value="3rd" {{ old('admission_sought_for_class') == '3rd' ? 'selected' : '' }}>3rd Standard</option>
                                            <option value="4th" {{ old('admission_sought_for_class') == '4th' ? 'selected' : '' }}>4th Standard</option>
                                            <option value="5th" {{ old('admission_sought_for_class') == '5th' ? 'selected' : '' }}>5th Standard</option>
                                        </select>
                                        <label for="admission_sought_for_class" class="required">Admission Sought For Class</label>
                                        @error('admission_sought_for_class')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Academic Year -->
                                <div class="col-md-6">
                                    <div class="form-floating shadow-sm">
                                        <select class="form-select @error('academic_year') is-invalid @enderror"
                                                name="academic_year" id="academic_year" required>
                                            <option value="">Select Academic Year</option>
                                            @php
                                                $currentYear = date('Y');
                                                for ($i = 0; $i < 3; $i++) {
                                                    $year = $currentYear + $i;
                                                    $nextYear = $year + 1;
                                                    $academicYear = $year . '-' . $nextYear;
                                                    $selected = (old('academic_year') == $academicYear) ? 'selected' : '';
                                                    echo "<option value='{$academicYear}' {$selected}>{$academicYear}</option>";
                                                }
                                            @endphp
                                        </select>
                                        <label for="academic_year" class="required">Academic Year</label>
                                        @error('academic_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Age Criteria Information -->
                                <div class="col-12">
                                    <div class="alert alert-info shadow-sm rounded-3">
                                        <h6 class="alert-heading d-flex align-items-center">
                                            <i class="fas fa-calendar-alt me-2"></i>Age Criteria for Admission:
                                        </h6>
                                        <ul class="mb-0">
                                            <li><strong>Nursery:</strong> 3+ years as on 1st June</li>
                                            <li><strong>Jr. KG (LKG):</strong> 4+ years as on 1st June</li>
                                            <li><strong>Sr. KG (UKG):</strong> 5+ years as on 1st June</li>
                                            <li><strong>1st Standard:</strong> 6+ years as on 1st June</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 6: Required Documents -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">6</span>
                                    <span><i class="fas fa-file-alt me-2"></i>Required Documents</span>
                                </h5>
                            </div>

                            <div class="documents-grid">
                                <!-- Birth Certificate -->
                                <div class="document-card shadow-sm">
                                    <div class="document-icon">
                                        <i class="fas fa-certificate text-primary"></i>
                                    </div>
                                    <div class="document-content">
                                        <label class="document-label">Birth Certificate</label>
                                        <input type="file" class="form-control @error('birth_certificate') is-invalid @enderror"
                                               name="birth_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                        @error('birth_certificate')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">PDF/JPG/PNG, max 5MB</small>
                                    </div>
                                </div>

                                <!-- Caste Certificate -->
                                <div class="document-card shadow-sm">
                                    <div class="document-icon">
                                        <i class="fas fa-file-contract text-success"></i>
                                    </div>
                                    <div class="document-content">
                                        <label class="document-label">Caste Certificate (If applicable)</label>
                                        <input type="file" class="form-control @error('caste_certificate') is-invalid @enderror"
                                               name="caste_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                        @error('caste_certificate')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">PDF/JPG/PNG, max 5MB</small>
                                    </div>
                                </div>

                                <!-- Leaving Certificate -->
                                <div class="document-card shadow-sm">
                                    <div class="document-icon">
                                        <i class="fas fa-graduation-cap text-warning"></i>
                                    </div>
                                    <div class="document-content">
                                        <label class="document-label">Leaving Certificate (If applicable)</label>
                                        <input type="file" class="form-control @error('leaving_certificate') is-invalid @enderror"
                                               name="leaving_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                        @error('leaving_certificate')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">PDF/JPG/PNG, max 5MB</small>
                                    </div>
                                </div>

                                <!-- Marksheet -->
                                <div class="document-card shadow-sm">
                                    <div class="document-icon">
                                        <i class="fas fa-chart-line text-danger"></i>
                                    </div>
                                    <div class="document-content">
                                        <label class="document-label">Previous Class Marksheet</label>
                                        <input type="file" class="form-control @error('marksheet') is-invalid @enderror"
                                               name="marksheet" accept=".pdf,.jpg,.jpeg,.png">
                                        @error('marksheet')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">PDF/JPG/PNG, max 5MB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3 shadow-sm rounded-3">
                                <h6 class="alert-heading d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Important Note:
                                </h6>
                                <p class="mb-0">
                                    All documents must be clear and legible. Original documents will need to be produced during admission process for verification.
                                </p>
                            </div>
                        </div>

                        <!-- Section 7: Declaration -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">7</span>
                                    <span><i class="fas fa-handshake me-2"></i>Declaration & Agreement</span>
                                </h5>
                            </div>

                            <div class="declaration-box border rounded-3 p-4 bg-light shadow-sm">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">School Rules and Regulations:</h6>
                                    <div class="rules-list">
                                        <div class="rule-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Regular attendance is compulsory for all students</span>
                                        </div>
                                        <div class="rule-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Students must reach school 10 minutes before assembly</span>
                                        </div>
                                        <div class="rule-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Complete school uniform must be worn on all working days</span>
                                        </div>
                                        <div class="rule-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Discipline and respect for teachers must be maintained</span>
                                        </div>
                                        <div class="rule-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Parents must attend all Parent-Teacher meetings</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check declaration-check">
                                    <input class="form-check-input @error('agreed_to_rules') is-invalid @enderror"
                                           type="checkbox" name="agreed_to_rules" id="agree_rules" value="1"
                                           {{ old('agreed_to_rules') ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-semibold" for="agree_rules">
                                        <i class="fas fa-handshake text-primary me-2"></i>
                                        I, the parent/guardian, hereby declare that I have read and understood all the rules and regulations of the School. I promise to abide by them and ensure that my ward conforms to the standards required in conduct and studies. I understand that any false information may lead to cancellation of admission.
                                    </label>
                                    @error('agreed_to_rules')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 8: Security Verification -->
                        <div class="form-section mb-5">
                            <div class="section-header bg-gradient-primary bg-opacity-10 p-3 rounded-3 mb-4 shadow-sm">
                                <h5 class="mb-0 text-primary d-flex align-items-center">
                                    <span class="badge bg-gradient-primary me-3 pulse">8</span>
                                    <span><i class="fas fa-shield-alt me-2"></i>Security Verification</span>
                                </h5>
                            </div>

                            <div class="verification-box border rounded-3 p-4 bg-light shadow-sm">
                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="{{ config('captcha.site_key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-shield-alt text-primary me-1"></i>
                                    This verification helps us prevent automated submissions and ensure security.
                                </p>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="form-section mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button type="reset" class="btn btn-outline-secondary w-100 py-3 shadow-sm">
                                        <i class="fas fa-redo me-2"></i>Clear Form
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button type="submit" class="btn btn-primary w-100 py-3 submit-btn shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    After submission, you will receive an application number and confirmation email.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Modern Color Palette */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* School Header */
    .bg-gradient-primary {
        background: var(--primary-gradient) !important;
    }

    .school-header h2 {
        font-size: 1.5rem;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .school-header h3 {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .school-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
    }

    /* Card Enhancements */
    .card {
        border: none !important;
        transition: transform 0.3s ease;
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }

    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    /* Progress Bar */
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        background: var(--primary-gradient);
        transition: width 0.6s ease;
    }

    /* Pulse Animation for Badges */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    /* Section Headers */
    .section-header {
        border-left: 5px solid #667eea;
        transition: all 0.3s ease;
    }

    .section-header:hover {
        transform: translateX(5px);
    }

    /* Form Floating Labels */
    .form-floating > .form-control,
    .form-floating > .form-select {
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        color: #667eea;
        font-weight: 600;
    }

    /* Required Field Indicator */
    .required:after {
        content: " *";
        color: #dc3545;
        font-weight: bold;
    }

    /* Photo Preview */
    .photo-preview-container {
        position: sticky;
        top: 20px;
    }

    .photo-preview {
        box-shadow: var(--card-shadow);
        background: white;
        transition: transform 0.3s ease;
    }

    .photo-preview:hover {
        transform: scale(1.02);
    }

    .photo-preview img {
        width: 100%;
        height: auto;
        max-height: 250px;
        object-fit: contain;
    }

    /* Image Requirements */
    .image-requirements {
        border-left: 4px solid #667eea;
        background: linear-gradient(to right, rgba(102, 126, 234, 0.05), transparent);
    }

    .image-requirements ul {
        list-style-type: none;
        padding-left: 0;
    }

    .image-requirements li {
        padding-left: 1.5rem;
        position: relative;
        margin-bottom: 0.5rem;
    }

    .image-requirements li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #43e97b;
        font-weight: bold;
        font-size: 1.2rem;
    }

    /* Documents Grid */
    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .document-card {
        border: 2px solid #e9ecef;
        border-radius: 1rem;
        padding: 1.5rem;
        background: white;
        transition: all 0.3s ease;
    }

    .document-card:hover {
        border-color: #667eea;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        transform: translateY(-5px);
    }

    .document-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .document-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: block;
        color: #495057;
        font-size: 1rem;
    }

    /* Rules List */
    .rules-list {
        background: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
    }

    .rule-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px dashed #e9ecef;
        transition: all 0.3s ease;
    }

    .rule-item:hover {
        padding-left: 0.5rem;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 0.5rem;
    }

    .rule-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Declaration Box */
    .declaration-box {
        border-left: 5px solid #43e97b;
    }

    .declaration-check .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.2em;
        cursor: pointer;
    }

    .declaration-check .form-check-input:checked {
        background-color: #43e97b;
        border-color: #43e97b;
    }

    .declaration-check .form-check-label {
        line-height: 1.6;
        cursor: pointer;
    }

    /* Verification Box */
    .verification-box {
        border-left: 5px solid #ffc107;
    }

    /* Submit Button */
    .submit-btn {
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        background: var(--primary-gradient);
        border: none;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-3px);
    }

    /* Form Validation */
    .is-invalid {
        border-color: #dc3545 !important;
        animation: shake 0.5s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }

    .invalid-feedback {
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Alert Enhancements */
    .alert {
        border: none;
        border-left: 5px solid;
    }

    .alert-info {
        background: linear-gradient(to right, rgba(13, 110, 253, 0.1), transparent);
        border-left-color: #0d6efd;
    }

    .alert-warning {
        background: linear-gradient(to right, rgba(255, 193, 7, 0.1), transparent);
        border-left-color: #ffc107;
    }

    .alert-success {
        background: linear-gradient(to right, rgba(67, 233, 123, 0.1), transparent);
        border-left-color: #43e97b;
    }

    .alert-danger {
        background: linear-gradient(to right, rgba(220, 53, 69, 0.1), transparent);
        border-left-color: #dc3545;
    }

    /* Shadow Utilities */
    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
    }

    /* Gradient Backgrounds */
    .bg-gradient-light {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .documents-grid {
            grid-template-columns: 1fr;
        }

        .photo-preview-container {
            position: static;
            margin-top: 1rem;
        }

        .school-header h2 {
            font-size: 1.2rem;
        }

        .school-header h3 {
            font-size: 1rem;
        }

        .section-header h5 {
            font-size: 1rem;
        }
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Input File Styling */
    input[type="file"] {
        cursor: pointer;
    }

    input[type="file"]::-webkit-file-upload-button {
        background: #667eea;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
        background: #764ba2;
        transform: scale(1.05);
    }
</style>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    // Image Preview Function
    function previewImage(input) {
        const preview = document.getElementById('photoPreview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.objectFit = 'cover';
            }

            reader.readAsDataURL(file);
            updateProgressBar();
        }
    }

    // Form Progress Tracking
    function updateProgressBar() {
        const form = document.getElementById('admissionForm');
        const requiredFields = form.querySelectorAll('[required]');
        const progressBar = document.getElementById('formProgress');

        let filledFields = 0;

        requiredFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (field.checked) filledFields++;
            } else if (field.type === 'file') {
                if (field.files.length > 0) filledFields++;
            } else {
                if (field.value.trim() !== '') filledFields++;
            }
        });

        const progress = (filledFields / requiredFields.length) * 100;
        progressBar.style.width = `${progress}%`;

        // Update progress bar color based on completion
        if (progress < 30) {
            progressBar.className = 'progress-bar bg-danger progress-bar-animated';
        } else if (progress < 70) {
            progressBar.className = 'progress-bar bg-warning progress-bar-animated';
        } else {
            progressBar.className = 'progress-bar bg-success progress-bar-animated';
        }
    }

    // Initialize form progress
    document.addEventListener('DOMContentLoaded', function() {
        // Set date restrictions for date of birth
        const dobField = document.getElementById('date_of_birth');
        if (dobField) {
            const today = new Date();
            const minDate = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate());
            const maxDate = new Date(today.getFullYear() - 3, today.getMonth(), today.getDate());

            dobField.max = maxDate.toISOString().split('T')[0];
            dobField.min = minDate.toISOString().split('T')[0];

            if (dobField.value) {
                const selectedDate = new Date(dobField.value);
                if (selectedDate < minDate || selectedDate > maxDate) {
                    dobField.value = '';
                }
            }
        }

        // Track form progress on input
        document.querySelectorAll('#admissionForm input, #admissionForm select, #admissionForm textarea').forEach(element => {
            element.addEventListener('input', updateProgressBar);
            element.addEventListener('change', updateProgressBar);
        });

        // Initial progress calculation
        updateProgressBar();

        // Form validation before submission
        document.getElementById('admissionForm').addEventListener('submit', function(e) {
            const reCaptchaResponse = grecaptcha.getResponse();
            const submitBtn = document.querySelector('.submit-btn');

            if (!reCaptchaResponse) {
                e.preventDefault();
                alert('Please complete the reCAPTCHA verification.');
                return false;
            }

            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

            return true;
        });

        // Clear form confirmation
        document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to clear all form data?')) {
                e.preventDefault();
            } else {
                updateProgressBar();
            }
        });

        // Add smooth scroll to sections on error
        if (document.querySelector('.alert-danger')) {
            document.querySelector('.alert-danger').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Mobile number formatting
    document.getElementById('mobile_1')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.substring(0, 10);
        e.target.value = value;
    });

    document.getElementById('mobile_2')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 10) value = value.substring(0, 10);
        e.target.value = value;
    });
</script>
@endsection
