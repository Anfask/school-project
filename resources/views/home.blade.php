@extends('layouts.app')

@section('title', 'P.A. INAMIDAR ENGLISH MEDIUM SCHOOL')

@section('content')
<div class="container-fluid">
    <!-- School Header -->
    <div class="school-header text-center py-5 bg-gradient-primary text-white rounded-4 mb-4">
        <h1 class="display-4 fw-bold mb-3">P.A. INAMIDAR ENGLISH MEDIUM SCHOOL</h1>
        <p class="lead mb-4">Affiliated to Maharashtra State Board • Est. 1995</p>
        <div class="school-badges">
            <span class="badge bg-light text-primary me-2 mb-2">ISO 9001:2015 Certified</span>
            <span class="badge bg-light text-primary me-2 mb-2">NAAC Accredited</span>
            <span class="badge bg-light text-primary mb-2">Best School Award 2023</span>
        </div>
    </div>

    <!-- School Details Section -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3">
                    <h3 class="mb-0"><i class="fas fa-school me-2"></i>About Our School</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-history me-2"></i>History</h5>
                            <p class="text-muted">
                                Established in 1995, P.A. Inamidar English Medium School has been providing quality education for over 28 years. Founded by the Iqra Education & Welfare Society, we believe in holistic development of every child.
                            </p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-eye me-2"></i>Vision</h5>
                            <p class="text-muted">
                                To create a learning environment that fosters academic excellence, moral values, and social responsibility, preparing students to face global challenges.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-bullseye me-2"></i>Mission</h5>
                            <p class="text-muted">
                                To provide comprehensive education that develops critical thinking, creativity, and character in a safe and nurturing environment.
                            </p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="text-primary mb-3"><i class="fas fa-award me-2"></i>Achievements</h5>
                            <ul class="text-muted">
                                <li>100% Board Results for 10 consecutive years</li>
                                <li>State-level Sports Champions 2022</li>
                                <li>Best Science Exhibition Award 2023</li>
                                <li>Digital School Award 2023</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Facilities -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3">
                    <h3 class="mb-0"><i class="fas fa-cogs me-2"></i>Facilities</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-desktop fa-3x text-primary"></i>
                            </div>
                            <h6>Smart Classrooms</h6>
                            <p class="small text-muted">Digital learning with interactive boards</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-flask fa-3x text-primary"></i>
                            </div>
                            <h6>Science Labs</h6>
                            <p class="small text-muted">Well-equipped Physics, Chemistry & Biology labs</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-book fa-3x text-primary"></i>
                            </div>
                            <h6>Library</h6>
                            <p class="small text-muted">15,000+ books and digital resources</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-futbol fa-3x text-primary"></i>
                            </div>
                            <h6>Sports Complex</h6>
                            <p class="small text-muted">Basketball, Football, Athletics facilities</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-laptop-medical fa-3x text-primary"></i>
                            </div>
                            <h6>Medical Room</h6>
                            <p class="small text-muted">24/7 medical assistance available</p>
                        </div>
                        <div class="col-md-4 text-center mb-4">
                            <div class="facility-icon mb-3">
                                <i class="fas fa-bus fa-3x text-primary"></i>
                            </div>
                            <h6>Transport</h6>
                            <p class="small text-muted">GPS-enabled school buses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Quick Info -->
        <div class="col-lg-4">
            <!-- Admission Process -->
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4 py-3">
                    <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Admission Process</h4>
                </div>
                <div class="card-body">
                    <div class="process-steps">
                        <div class="step mb-4">
                            <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <span>1</span>
                            </div>
                            <h6>Select Form</h6>
                            <p class="small text-muted">Choose the appropriate form based on class</p>
                        </div>
                        <div class="step mb-4">
                            <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <span>2</span>
                            </div>
                            <h6>Fill Details</h6>
                            <p class="small text-muted">Complete the online application form</p>
                        </div>
                        <div class="step mb-4">
                            <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <span>3</span>
                            </div>
                            <h6>Upload Documents</h6>
                            <p class="small text-muted">Submit required documents online</p>
                        </div>
                        <div class="step mb-0">
                            <div class="step-icon bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <span>4</span>
                            </div>
                            <h6>Get Confirmation</h6>
                            <p class="small text-muted">Receive admission confirmation via email</p>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('admission.select') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-pencil-alt me-2"></i>Start Admission Process
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4 py-3">
                    <h4 class="mb-0"><i class="fas fa-address-card me-2"></i>Contact Information</h4>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="d-flex mb-3">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Address</h6>
                                <p class="small text-muted mb-0">
                                    P.A. Inamidar English Medium School<br>
                                    Iqra Education Complex,<br>
                                    Near Municipal Office,<br>
                                    Pune, Maharashtra 411001
                                </p>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone Numbers</h6>
                                <p class="small text-muted mb-0">
                                    Office: +91 20 1234 5678<br>
                                    Principal: +91 98765 43210<br>
                                    Admissions: +91 98765 43211
                                </p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="small text-muted mb-0">
                                    info@inamidarschool.edu.in<br>
                                    admissions@inamidarschool.edu.in
                                </p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="tel:+912012345678" class="btn btn-outline-primary me-2">
                                <i class="fas fa-phone me-1"></i> Call Now
                            </a>
                            <a href="mailto:info@inamidarschool.edu.in" class="btn btn-outline-success">
                                <i class="fas fa-envelope me-1"></i> Email Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admission Forms Selection -->
    <div class="card shadow-lg border-0 rounded-4 mb-5">
        <div class="card-header bg-gradient-warning text-white rounded-top-4 py-3">
            <h3 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Select Admission Form</h3>
        </div>
        <div class="card-body">
            <p class="text-center mb-4">Please select the appropriate admission form based on the class you're applying for:</p>

            <div class="row g-4">
                <!-- Form 1 -->
                <div class="col-md-4">
                    <div class="form-card text-center h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="form-icon mb-3">
                            <i class="fas fa-child fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Form 1</h4>
                        <h5 class="text-success mb-3">Pre-primary to Class 2</h5>
                        <p class="text-muted mb-4">
                            For admission to Nursery, LKG, UKG, Class 1 & Class 2
                        </p>
                        <a href="{{ route('admission.form1') }}" class="btn btn-primary w-100">
                            <i class="fas fa-play me-2"></i>Start Form 1
                        </a>
                    </div>
                </div>

                <!-- Form 2 -->
                <div class="col-md-4">
                    <div class="form-card text-center h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="form-icon mb-3">
                            <i class="fas fa-user-graduate fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Form 2</h4>
                        <h5 class="text-success mb-3">Class 3 to Class 10</h5>
                        <p class="text-muted mb-4">
                            Complete student details with additional information and documents
                        </p>
                        <a href="{{ route('admission.form2') }}" class="btn btn-primary w-100">
                            <i class="fas fa-play me-2"></i>Start Form 2
                        </a>
                    </div>
                </div>

                <!-- Form 3 -->
                <div class="col-md-4">
                    <div class="form-card text-center h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="form-icon mb-3">
                            <i class="fas fa-university fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Form 3</h4>
                        <h5 class="text-success mb-3">Higher Secondary (11th-12th)</h5>
                        <p class="text-muted mb-4">
                            With Arts & Science stream selection and subject groups
                        </p>
                        <a href="{{ route('admission.form3') }}" class="btn btn-primary w-100">
                            <i class="fas fa-play me-2"></i>Start Form 3
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }

    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }

    .school-header {
        border-radius: 1rem;
        padding: 3rem 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .school-badges .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .form-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .form-card:hover {
        transform: translateY(-10px);
        border-color: #667eea;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    }

    .hover-shadow:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .process-steps .step-icon {
        width: 40px;
        height: 40px;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .contact-icon {
        width: 30px;
        text-align: center;
        font-size: 1.2rem;
    }

    .facility-icon i {
        transition: transform 0.3s ease;
    }

    .facility-icon:hover i {
        transform: scale(1.2);
    }

    .card {
        border: none;
    }
</style>
@endsection
