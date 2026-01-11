@extends('admin.layout')

@section('title', 'Application Details')
@section('page-title', 'Application Details')
@section('page-subtitle', 'View and manage application')

@section('content')
    <div class="row fade-in">
        <div class="col-lg-8">
            <!-- Application Header Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-user-graduate me-2"></i>
                            Application #{{ $application->id }}
                        </h5>
                        <small class="text-muted">Submitted: {{ $application->created_at->format('F d, Y h:i A') }}</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#editApplicationModal">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <span class="badge
                                        @if($application->status == 'accepted') bg-success
                                        @elseif($application->status == 'reviewed') bg-info
                                        @elseif($application->status == 'rejected') bg-danger
                                        @else bg-warning
                                        @endif fs-6">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $application->first_name }} {{ $application->surname }}</h6>
                                    <small class="text-muted">{{ $application->email }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-graduation-cap text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $application->admission_sought_for_class ?? 'N/A' }}</h6>
                                    <small class="text-muted">Class Applied For</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $application->mobile_1 ?? 'N/A' }}</h6>
                                    <small class="text-muted">Primary Contact</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i> Personal Information</h5>
                    <span class="badge
                            @if($application->form_type == 'form1') bg-info
                            @elseif($application->form_type == 'form2') bg-success
                            @elseif($application->form_type == 'form3') bg-warning
                            @else bg-secondary @endif">
                        @if($application->form_type == 'form1') Form 1 (Pre-primary to Class 2)
                        @elseif($application->form_type == 'form2') Form 2 (Class 3 to 10)
                        @elseif($application->form_type == 'form3') Form 3 (Higher Secondary)
                        @else N/A @endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Full Name</label>
                            <p class="fs-5">
                                <strong>{{ $application->full_name ?? ($application->first_name . ' ' . $application->surname) }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Gender</label>
                            <p class="fs-5">
                                <i
                                    class="fas fa-{{ strtolower($application->gender) == 'male' ? 'male' : 'female' }} text-primary me-2"></i>
                                {{ $application->gender ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Date of Birth</label>
                            <p class="fs-5">
                                <i class="fas fa-birthday-cake text-info me-2"></i>
                                @if($application->date_of_birth)
                                    {{ \Carbon\Carbon::parse($application->date_of_birth)->format('F d, Y') }}
                                    @if($application->date_of_birth_words)
                                        <br><small class="text-muted">({{ $application->date_of_birth_words }})</small>
                                    @endif
                                    <br><small class="text-muted">({{ \Carbon\Carbon::parse($application->date_of_birth)->age }}
                                        years old)</small>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Place of Birth</label>
                            <p class="fs-5">{{ $application->place_of_birth ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Religion</label>
                            <p class="fs-5">{{ $application->religion ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Caste</label>
                            <p class="fs-5">{{ $application->caste ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Nationality</label>
                            <p class="fs-5">{{ $application->nationality ?? 'N/A' }}</p>
                        </div>

                        @if($application->mother_tongue)
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Mother Tongue</label>
                                <p class="fs-5">{{ $application->mother_tongue }}</p>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Physically Unfit</label>
                            <p class="fs-5">
                                @if($application->is_physically_unfit)
                                    <span class="badge bg-danger">Yes</span>
                                @else
                                    <span class="badge bg-success">No</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($application->aadhar_no)
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Aadhar Number</label>
                                <p class="fs-5">{{ $application->aadhar_no }}</p>
                            </div>
                            @if($application->id_type)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">ID Type</label>
                                    <p class="fs-5">{{ $application->id_type }}</p>
                                </div>
                            @endif
                            @if($application->id_number)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">ID Number</label>
                                    <p class="fs-5">{{ $application->id_number }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-address-book me-2"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Email Address</label>
                            <p class="fs-5">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <a href="mailto:{{ $application->email }}"
                                    class="text-decoration-none">{{ $application->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Primary Phone</label>
                            <p class="fs-5">
                                <i class="fas fa-phone text-success me-2"></i>
                                <a href="tel:{{ $application->mobile_1 }}"
                                    class="text-decoration-none">{{ $application->mobile_1 ?? 'N/A' }}</a>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Secondary Phone</label>
                            <p class="fs-5">
                                <i class="fas fa-phone-alt text-success me-2"></i>
                                {{ $application->mobile_2 ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Local Address</label>
                            <p class="fs-5">
                                <i class="fas fa-home text-warning me-2"></i>
                                {{ $application->local_address ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Permanent Address</label>
                            <p class="fs-5">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $application->permanent_address ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">City</label>
                            <p class="fs-5">{{ $application->city ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">State</label>
                            <p class="fs-5">{{ $application->state ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Pincode</label>
                            <p class="fs-5">{{ $application->pincode ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($application->address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Additional Address</label>
                            <p class="fs-5">{{ $application->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Parent Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i> Parent Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Father's Information -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Father's Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Full Name</label>
                                    <p class="fs-5">
                                        {{ $application->father_name ?? $application->father_full_name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Occupation</label>
                                    <p class="fs-5">{{ $application->father_occupation ?? 'N/A' }}</p>
                                </div>
                                @if($application->father_designation)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Designation</label>
                                        <p class="fs-5">{{ $application->father_designation }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Mother's Information -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Mother's Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Full Name</label>
                                    <p class="fs-5">
                                        {{ $application->mother_name ?? $application->mother_full_name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Occupation</label>
                                    <p class="fs-5">{{ $application->mother_occupation ?? 'N/A' }}</p>
                                </div>
                                @if($application->mother_designation)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted">Designation</label>
                                        <p class="fs-5">{{ $application->mother_designation }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($application->parents_guardian_full_name)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Guardian Information</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label text-muted">Guardian Name</label>
                                        <p class="fs-5">{{ $application->parents_guardian_full_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Educational Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i> Educational Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Class Applied For</label>
                            <p class="fs-5">
                                <i class="fas fa-graduation-cap text-primary me-2"></i>
                                <strong>
                                    @if($application->form_type == 'form1')
                                        {{ $application->admission_sought_for_class ?? 'N/A' }}
                                    @elseif(in_array($application->form_type, ['form2', 'form3']))
                                        {{ $application->admission_class ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </strong>
                            </p>
                        </div>

                        @if($application->academic_year)
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Academic Year</label>
                                <p class="fs-5">
                                    <i class="fas fa-calendar-alt text-success me-2"></i>
                                    {{ $application->academic_year }}
                                </p>
                            </div>
                        @endif

                        @if($application->application_number)
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Application Number</label>
                                <p class="fs-5">
                                    <i class="fas fa-hashtag text-info me-2"></i>
                                    {{ $application->application_number }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if($application->last_school_attended)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Last School Attended</label>
                                <p class="fs-5">{{ $application->last_school_attended }}</p>
                            </div>
                            @if($application->last_school_address)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted">Last School Address</label>
                                    <p class="fs-5">{{ $application->last_school_address }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($application->studying_in_std)
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Currently Studying</label>
                                <p class="fs-5">{{ $application->studying_in_std }}</p>
                            </div>
                            @if($application->medium_of_instruction)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Medium of Instruction</label>
                                    <p class="fs-5">{{ $application->medium_of_instruction }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            @if($application->form_type == 'form3')
                <!-- Stream and Subject Information (Form 3 Only) -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-university me-2"></i> Stream & Subject Selection</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($application->stream)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Stream</label>
                                    <p class="fs-5">
                                        <i class="fas fa-stream text-primary me-2"></i>
                                        <strong>{{ $application->stream }}</strong>
                                    </p>
                                </div>
                            @endif

                            @if($application->subject_group)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Subject Group</label>
                                    <p class="fs-5">
                                        <i class="fas fa-layer-group text-success me-2"></i>
                                        {{ $application->subject_group }}
                                    </p>
                                </div>
                            @endif

                            @if($application->admission_class)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-muted">Admission Class</label>
                                    <p class="fs-5">
                                        <i class="fas fa-graduation-cap text-warning me-2"></i>
                                        {{ $application->admission_class }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($application->selected_subjects)
                            <div class="mb-3">
                                <label class="form-label text-muted">Selected Subjects</label>
                                <div class="row">
                                    @foreach(json_decode($application->selected_subjects, true) as $subject)
                                        <div class="col-md-3 mb-2">
                                            <span class="badge bg-primary">{{ $subject }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Address Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i> Address Information</h5>
                </div>
                <div class="card-body">
                    @if($application->present_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Present Address</label>
                            <p class="fs-5">{{ $application->present_address }}</p>
                        </div>
                    @endif

                    @if($application->permanent_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Permanent Address</label>
                            <p class="fs-5">{{ $application->permanent_address }}</p>
                        </div>
                    @endif

                    @if(!$application->present_address && !$application->permanent_address && $application->local_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Address</label>
                            <p class="fs-5">{{ $application->local_address ?? $application->address ?? 'N/A' }}</p>
                        </div>
                    @endif

                    <div class="row">
                        @if($application->pin_code)
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">PIN Code</label>
                                <p class="fs-5">{{ $application->pin_code }}</p>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Contact Numbers</label>
                            <p class="fs-5">
                                @if($application->phone_no1 || $application->mobile_1)
                                    <i class="fas fa-phone text-success me-2"></i>
                                    {{ $application->phone_no1 ?? $application->mobile_1 ?? 'N/A' }}<br>
                                @endif
                                @if($application->phone_no2 || $application->mobile_2)
                                    <i class="fas fa-phone-alt text-success me-2"></i>
                                    {{ $application->phone_no2 ?? $application->mobile_2 }}
                                @endif
                            </p>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p class="fs-5">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <a href="mailto:{{ $application->email }}"
                                    class="text-decoration-none">{{ $application->email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i> Documents Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @php
                            $docs = [
                                [
                                    'label' => 'Student Photo',
                                    'path' => $application->student_photo_path ?? $application->passport_photo_path,
                                    'icon' => 'fa-user'
                                ],
                                [
                                    'label' => 'Birth Certificate',
                                    'path' => $application->birth_certificate_path,
                                    'icon' => 'fa-baby'
                                ],
                                [
                                    'label' => 'Caste Certificate',
                                    'path' => $application->caste_certificate_path,
                                    'icon' => 'fa-id-card'
                                ],
                                [
                                    'label' => 'Leaving Certificate',
                                    'path' => $application->leaving_certificate_path,
                                    'icon' => 'fa-file-export'
                                ],
                                [
                                    'label' => 'Marksheet',
                                    'path' => $application->marksheet_path,
                                    'icon' => 'fa-file-invoice'
                                ],
                                [
                                    'label' => 'Family Photo',
                                    'path' => $application->family_photo_path,
                                    'icon' => 'fa-users'
                                ]
                            ];
                        @endphp

                        @foreach($docs as $doc)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="doc-box">
                                    <div class="doc-title">{{ $doc['label'] }}</div>
                                    
                                    @if($doc['path'])
                                        @php
                                            $url = route('admin.file.serve', ['path' => base64_encode($doc['path'])]);
                                            $ext = strtolower(pathinfo($doc['path'], PATHINFO_EXTENSION));
                                            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                        @endphp
                                        
                                        @if($isImage)
                                            <img src="{{ $url }}" class="doc-preview-thumb" alt="{{ $doc['label'] }}">
                                        @else
                                            <div class="doc-placeholder">
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="doc-actions">
                                            <a href="{{ $url }}" download target="_blank" 
                                                class="btn btn-sm btn-outline-secondary rounded-circle" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="doc-placeholder">
                                            <i class="fas {{ $doc['icon'] }} opacity-25"></i>
                                        </div>
                                        <div class="text-muted small">Not uploaded</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Document Preview Modal -->
            <div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">Document Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <div class="bg-light rounded-3 p-3 d-flex align-items-center justify-content-center"
                                style="min-height: 400px; position: relative;">
                                <div id="previewSpinner" class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <img id="previewImage" src="" class="img-fluid rounded shadow-sm"
                                    style="display: none; max-height: 75vh; width: auto; margin: 0 auto;">
                                <embed id="previewPdf" src="" type="application/pdf" class="rounded shadow-sm"
                                    style="display: none; width: 100%; height: 75vh; border: none;"></embed>
                                <div id="previewError" style="display: none;" class="text-danger p-4 w-100">
                                    <div class="mb-3">
                                        <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="fw-bold">Preview Loading Issue</h5>
                                    <p class="text-muted small mb-4">The document could not be previewed directly in this window. This can happen with some browser security settings.</p>
                                    <div class="d-grid gap-2 col-md-8 mx-auto">
                                        <a href="" id="pdfFallbackLink" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>View in New Tab
                                        </a>
                                        <a href="" id="manualDownloadBtn" download class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-download me-2"></i>Download File
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <a href="" id="openInNewTab" target="_blank" class="btn btn-link text-decoration-none me-auto">
                                <i class="fas fa-external-link-alt me-1"></i> Open in New Tab
                            </a>
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                            <a href="" id="downloadBtn" download class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function showPreview(url, type) {
                    console.log('Requesting preview:', url, 'Type:', type);
                    
                    const modalEl = document.getElementById('documentPreviewModal');
                    const imgInfo = document.getElementById('previewImage');
                    const pdfInfo = document.getElementById('previewPdf');
                    const pdfFallback = document.getElementById('pdfFallbackLink');
                    const manualDownload = document.getElementById('manualDownloadBtn');
                    const openNewTab = document.getElementById('openInNewTab');
                    const spinner = document.getElementById('previewSpinner');
                    const error = document.getElementById('previewError');
                    const downloadBtn = document.getElementById('downloadBtn');

                    // Reset State
                    imgInfo.style.display = 'none';
                    imgInfo.src = '';
                    pdfInfo.style.display = 'none';
                    pdfInfo.src = ''; 
                    error.style.display = 'none';
                    spinner.style.display = 'block';

                    // Update Links
                    downloadBtn.href = url;
                    openNewTab.href = url;
                    if(pdfFallback) pdfFallback.href = url;
                    if(manualDownload) manualDownload.href = url;

                    // Show Modal
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();

                    // Load Content
                    setTimeout(() => {
                        if (type === 'image') {
                            imgInfo.onload = function () {
                                spinner.style.display = 'none';
                                imgInfo.style.display = 'block';
                            };
                            imgInfo.onerror = function () {
                                spinner.style.display = 'none';
                                error.style.display = 'block';
                            };
                            imgInfo.src = url;
                        } else if (type === 'pdf') {
                            pdfInfo.src = url;
                            
                            // For <embed>, we wait a bit then show it. 
                            // If it fails to render, the user has the fallback buttons in the error div (though error div is hidden by default)
                            // We can also show the fallback after a timeout if we're not sure
                            setTimeout(() => {
                                spinner.style.display = 'none';
                                pdfInfo.style.display = 'block';
                                
                                // Show fallback as well if it's taking too long or as a "just in case"
                                setTimeout(() => {
                                    if(pdfInfo.style.display === 'block') {
                                        // Still visible, but let's make error div as a hidden backup
                                    }
                                }, 3000);
                            }, 600);
                        } else {
                            spinner.style.display = 'none';
                            error.style.display = 'block';
                        }
                    }, 300);
                }
            </script>

            <!-- Declaration & Agreement Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i> Declaration & Agreement</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Agreed to Rules & Regulations</label>
                            <p class="fs-5">
                                @if($application->agreed_to_rules)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Application Created</label>
                            <p class="fs-5">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $application->created_at->format('F d, Y h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Card -->
            @if($application->additional_info || $application->remarks)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Additional Information & Remarks</h5>
                    </div>
                    <div class="card-body">
                        @if($application->additional_info)
                            <div class="mb-4">
                                <label class="form-label text-muted">Additional Information</label>
                                <p>{{ $application->additional_info }}</p>
                            </div>
                        @endif

                        @if($application->remarks)
                            <div>
                                <label class="form-label text-muted">Remarks</label>
                                <p>{{ $application->remarks }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" id="sendApplicationEmailBtn">
                            <i class="fas fa-paper-plane me-2"></i> Send Application Email
                        </button>
                        @if($application->mobile_1)
                            <a href="tel:{{ $application->mobile_1 }}" class="btn btn-outline-success">
                                <i class="fas fa-phone me-2"></i> Make Call
                            </a>
                        @endif
                        <a href="{{ route('admin.application.download', $application->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i> Download PDF
                        </a>
                        <button class="btn btn-outline-warning" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print Application
                        </button>

                        <!-- View Documents -->
                        @if($application->passport_photo_path)
                            <a href="{{ route('admin.file.serve', ['path' => base64_encode($application->passport_photo_path)]) }}"
                                target="_blank" class="btn btn-outline-secondary">
                                <i class="fas fa-id-card me-2"></i> View Passport Photo
                            </a>
                        @endif

                        @if($application->family_photo_path)
                            <a href="{{ route('admin.file.serve', ['path' => base64_encode($application->family_photo_path)]) }}"
                                target="_blank" class="btn btn-outline-secondary">
                                <i class="fas fa-users me-2"></i> View Family Photo
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Update Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Update Status</h5>
                </div>
                <div class="card-body">
                    <form id="statusForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Current Status</label>
                            <select class="form-select" name="status" id="statusSelect">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed
                                </option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted
                                </option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="3"
                                placeholder="Add remarks (optional)">{{ $application->remarks ?? '' }}</textarea>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="updateStatusBtn">
                            <i class="fas fa-save me-2"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i> Application Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Application Submitted</h6>
                                <small class="text-muted">{{ $application->created_at->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>

                        @if($application->status_updated_at)
                            <div class="timeline-item">
                                <div class="timeline-marker
                                                        @if($application->status == 'accepted') bg-success
                                                        @elseif($application->status == 'reviewed') bg-info
                                                        @elseif($application->status == 'rejected') bg-danger
                                                        @else bg-warning
                                                        @endif"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Status Updated</h6>
                                    <small
                                        class="text-muted">{{ $application->status_updated_at->format('M d, Y h:i A') }}</small>
                                    <div class="mt-1">
                                        <span class="badge
                                                                @if($application->status == 'accepted') bg-success
                                                                @elseif($application->status == 'reviewed') bg-info
                                                                @elseif($application->status == 'rejected') bg-danger
                                                                @else bg-warning
                                                                @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($application->updated_at && $application->updated_at->gt($application->created_at))
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Last Updated</h6>
                                    <small class="text-muted">{{ $application->updated_at->format('M d, Y h:i A') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Application Meta Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Application Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Application ID</span>
                            <strong>#{{ $application->id }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Created</span>
                            <span>{{ $application->created_at->diffForHumans() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Last Updated</span>
                            <span>{{ $application->updated_at->diffForHumans() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Status</span>
                            <span class="badge
                                            @if($application->status == 'accepted') bg-success
                                            @elseif($application->status == 'reviewed') bg-info
                                            @elseif($application->status == 'rejected') bg-danger
                                            @else bg-warning
                                            @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </li>
                        @if($application->application_number)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>App Number</span>
                                <strong>{{ $application->application_number }}</strong>
                            </li>
                        @endif
                        @if($application->admission_sought_for_class)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>Class Applied</span>
                                <strong>{{ $application->admission_sought_for_class }}</strong>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Photo Preview Card (if available) -->
            @if($application->passport_photo_path)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i> Passport Photo</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ route('admin.file.serve', ['path' => base64_encode($application->passport_photo_path)]) }}"
                            alt="Passport Photo" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </div>
            @endif

            @if($application->family_photo_path)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Family Photo</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ route('admin.file.serve', ['path' => base64_encode($application->family_photo_path)]) }}"
                            alt="Family Photo" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="sendEmailModalLabel">
                        <i class="fas fa-paper-plane me-2"></i>
                        Send Application Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Preview Card -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Email Preview</h6>
                                </div>
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                    <div class="email-preview">
                                        <div
                                            style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0;">
                                            <h4 style="margin: 0;">{{ config('app.name', 'Admission System') }}</h4>
                                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Application Status Update</p>
                                        </div>

                                        <div style="padding: 20px; background: {{
        $application->status == 'accepted' ? '#10b981' :
        ($application->status == 'rejected' ? '#ef4444' :
            ($application->status == 'reviewed' ? '#3b82f6' : '#f59e0b'))
                                                    }}; color: white; text-align: center;">
                                            <h5 style="margin: 0;">
                                                @if($application->status == 'accepted')
                                                    🎉 Congratulations!
                                                @else
                                                    📋 Application Update
                                                @endif
                                            </h5>
                                            <p style="margin: 5px 0 0 0; opacity: 0.9;">
                                                Status: <strong>{{ ucfirst($application->status) }}</strong>
                                            </p>
                                        </div>

                                        <div style="padding: 20px; background: #f8fafc;">
                                            <p style="margin: 0 0 15px 0;">
                                                Dear <strong>{{ $application->first_name }}
                                                    {{ $application->surname }}</strong>,
                                            </p>
                                            <p style="margin: 0 0 15px 0; color: #64748b;">
                                                This email contains your application details and current status.
                                                A PDF copy of your application is attached.
                                            </p>

                                            <div
                                                style="background: white; border-radius: 8px; padding: 15px; margin: 15px 0; border-left: 4px solid #3b82f6;">
                                                <div
                                                    style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                                    <div>
                                                        <small style="color: #64748b;">Application ID</small>
                                                        <p style="margin: 5px 0; font-weight: 600;">#{{ $application->id }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <small style="color: #64748b;">Class Applied</small>
                                                        <p style="margin: 5px 0; font-weight: 600;">
                                                            {{ $application->admission_sought_for_class ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <small style="color: #64748b;">Status</small>
                                                        <p style="margin: 5px 0;">
                                                            <span
                                                                style="display: inline-block; padding: 3px 10px; background: {{
        $application->status == 'accepted' ? '#10b981' :
        ($application->status == 'rejected' ? '#ef4444' :
            ($application->status == 'reviewed' ? '#3b82f6' : '#f59e0b'))
                                                                        }}; color: white; border-radius: 20px; font-size: 12px;">
                                                                {{ ucfirst($application->status) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <small style="color: #64748b;">Date</small>
                                                        <p style="margin: 5px 0; font-weight: 600;">
                                                            {{ $application->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Recipient Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Recipient</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Student Name</strong></label>
                                        <p>{{ $application->first_name }} {{ $application->surname }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Email Address</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" value="{{ $application->email }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Application ID</strong></label>
                                        <p>#{{ $application->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-paperclip me-2"></i>Attachments</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <div
                                                style="width: 40px; height: 40px; background: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p style="margin: 0; font-weight: 600;">Application-{{ $application->id }}.pdf
                                            </p>
                                            <small style="color: #64748b;">Application details PDF</small>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="includeRemarks" checked>
                                        <label class="form-check-label" for="includeRemarks">
                                            Include status remarks
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sendCopy" checked>
                                        <label class="form-check-label" for="sendCopy">
                                            Send copy to admin
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Message -->
                    <div class="mb-3">
                        <label for="additionalMessage" class="form-label">Additional Message (Optional)</label>
                        <textarea class="form-control" id="additionalMessage" rows="3"
                            placeholder="Add a personal message to the student..."></textarea>
                    </div>

                    <!-- Email Subject -->
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Email Subject</label>
                        <input type="text" class="form-control" id="emailSubject"
                            value="Application Status Update - {{ config('app.name', 'Admission System') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="sendEmailBtn">
                        <i class="fas fa-paper-plane me-2"></i>Send Email
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Application Modal -->
    <div class="modal fade" id="editApplicationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.application.update', $application->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white border-0 pb-3">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-edit me-2"></i> Edit Application #{{ $application->id }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label font-weight-bold">First Name</label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $application->first_name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Surname</label>
                                        <input type="text" name="surname" class="form-control"
                                            value="{{ $application->surname }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $application->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile 1 (Primary)</label>
                                        <input type="text" name="mobile_1" class="form-control"
                                            value="{{ $application->mobile_1 }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile 2</label>
                                        <input type="text" name="mobile_2" class="form-control"
                                            value="{{ $application->mobile_2 }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Admission Class</label>
                                        <input type="text" name="admission_sought_for_class" class="form-control"
                                            value="{{ $application->admission_sought_for_class }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                            value="{{ $application->date_of_birth ? $application->date_of_birth->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="Male" {{ strtolower($application->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ strtolower($application->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ strtolower($application->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Aadhar No</label>
                                        <input type="text" name="aadhar_no" class="form-control"
                                            value="{{ $application->aadhar_no }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Place of Birth</label>
                                        <input type="text" name="place_of_birth" class="form-control"
                                            value="{{ $application->place_of_birth }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="2">{{ $application->address ?? $application->present_address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Upload -->
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-file-upload me-2"></i>Update Documents
                                </h6>
                                <p class="small text-muted mb-3">Uploading a new file will replace the existing one.</p>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Student Photo</label>
                                        <input type="file" name="student_photo" class="form-control form-control-sm">
                                        @if($application->student_photo_path || $application->passport_photo_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing photo present</small>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Birth Certificate</label>
                                        <input type="file" name="birth_certificate" class="form-control form-control-sm">
                                        @if($application->birth_certificate_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing file present</small>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Caste Certificate</label>
                                        <input type="file" name="caste_certificate" class="form-control form-control-sm">
                                        @if($application->caste_certificate_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing file present</small>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Leaving Certificate</label>
                                        <input type="file" name="leaving_certificate" class="form-control form-control-sm">
                                        @if($application->leaving_certificate_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing file present</small>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Marksheet</label>
                                        <input type="file" name="marksheet" class="form-control form-control-sm">
                                        @if($application->marksheet_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing file present</small>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Family Photo</label>
                                        <input type="file" name="family_photo" class="form-control form-control-sm">
                                        @if($application->family_photo_path)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Existing file present</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .timeline-content {
            padding-left: 10px;
        }

        .fs-5 {
            font-size: 1.1rem !important;
            margin-bottom: 0.5rem;
        }

        /* Document Box Styles */
        .doc-box {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
        }

        .doc-box:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .doc-preview-thumb {
            width: 100%;
            height: 120px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            background: #fff;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .doc-placeholder {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eceef0;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            color: #adb5bd;
        }

        .doc-placeholder i {
            font-size: 3rem;
        }

        .doc-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .doc-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
    </style>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Update status
                $('#updateStatusBtn').click(function () {
                    const formData = $('#statusForm').serialize();

                    $.ajax({
                        url: '{{ route("admin.application.status", $application->id) }}',
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            if (response.success) {
                                // Update status badge in header
                                const statusBadge = $('.card-header .badge');
                                statusBadge.removeClass('bg-warning bg-info bg-success bg-danger');

                                // Add appropriate class based on new status
                                if (response.status === 'accepted') {
                                    statusBadge.addClass('bg-success');
                                } else if (response.status === 'reviewed') {
                                    statusBadge.addClass('bg-info');
                                } else if (response.status === 'rejected') {
                                    statusBadge.addClass('bg-danger');
                                } else {
                                    statusBadge.addClass('bg-warning');
                                }

                                statusBadge.text(response.status_text);

                                // Update status in meta card
                                const metaStatusBadge = $('.list-group-item:has(span:contains("Status")) .badge');
                                metaStatusBadge.removeClass('bg-warning bg-info bg-success bg-danger');
                                if (response.status === 'accepted') {
                                    metaStatusBadge.addClass('bg-success').text('Accepted');
                                } else if (response.status === 'reviewed') {
                                    metaStatusBadge.addClass('bg-info').text('Reviewed');
                                } else if (response.status === 'rejected') {
                                    metaStatusBadge.addClass('bg-danger').text('Rejected');
                                } else {
                                    metaStatusBadge.addClass('bg-warning').text('Pending');
                                }

                                // Show success message
                                const toast = `
                                                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                                        <div class="toast show" role="alert">
                                                            <div class="toast-header bg-success text-white">
                                                                <strong class="me-auto">Success</strong>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                                            </div>
                                                            <div class="toast-body">
                                                                ${response.message}
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;

                                $('body').append(toast);

                                // Remove toast after 3 seconds
                                setTimeout(() => {
                                    $('.toast').remove();
                                }, 3000);

                                // Optionally reload the page to show updated timeline
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function (xhr) {
                            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                        }
                    });
                });

                // Email sending functionality
                $('#sendApplicationEmailBtn').click(function () {
                    $('#sendEmailModal').modal('show');
                });

                // Handle send email button click
                $('#sendEmailBtn').click(function () {
                    const button = $(this);
                    const originalText = button.html();

                    // Disable button and show loading
                    button.prop('disabled', true).html(`
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Sending...
                                `);

                    // Get form data
                    const additionalMessage = $('#additionalMessage').val();
                    const emailSubject = $('#emailSubject').val();
                    const includeRemarks = $('#includeRemarks').is(':checked');
                    const sendCopy = $('#sendCopy').is(':checked');

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route("admin.application.send-email", $application->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            message: additionalMessage,
                            subject: emailSubject,
                            include_remarks: includeRemarks ? '1' : '0', // Send as string '1' or '0'
                            send_copy_to_admin: sendCopy ? '1' : '0' // Send as string '1' or '0'
                        },
                        success: function (response) {
                            if (response.success) {
                                // Show success toast
                                showToast('success', 'Email Sent!', response.message);

                                // Close modal
                                $('#sendEmailModal').modal('hide');

                                // Reset form
                                $('#additionalMessage').val('');
                            } else {
                                showToast('error', 'Error', response.message);
                            }
                        },
                        error: function (xhr) {
                            showToast('error', 'Error', xhr.responseJSON?.message || 'Failed to send email');
                        },
                        complete: function () {
                            // Reset button
                            button.prop('disabled', false).html(originalText);
                        }
                    });
                });

                // Helper function to show toast
                function showToast(type, title, message) {
                    const toastHtml = `
                                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                            <div class="toast show" role="alert">
                                                <div class="toast-header ${type === 'success' ? 'bg-success' : 'bg-danger'} text-white">
                                                    <strong class="me-auto">${title}</strong>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                                                </div>
                                                <div class="toast-body">
                                                    ${message}
                                                </div>
                                            </div>
                                        </div>
                                    `;

                    $('body').append(toastHtml);

                    // Remove toast after 5 seconds
                    setTimeout(() => {
                        $('.toast').remove();
                    }, 5000);
                }
            });
        </script>
    @endpush
@endsection