@extends('layouts.app')

@section('title', 'Select Admission Form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-4">
                    <h2 class="text-center mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Select Admission Form
                    </h2>
                </div>

                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h4 class="text-primary mb-3">Academic Year: {{ $academicYear }}</h4>
                        <p class="text-muted">Please select the appropriate form based on the class you're applying for:</p>
                    </div>

                    <form action="{{ route('admission.select.post') }}" method="POST" id="formSelection">
                        @csrf

                        <div class="row g-4">
                            <!-- Form 1 -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="selected_form"
                                       id="form1" value="form1" autocomplete="off" required>
                                <label class="btn btn-outline-primary p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                       for="form1">
                                    <i class="fas fa-child fa-3x mb-3 text-primary"></i>
                                    <h5>Form 1</h5>
                                    <p class="mb-1 text-success fw-bold">Pre-primary to Class 2</p>
                                    <small class="text-muted text-center">
                                        Nursery, LKG, UKG, Class 1 & 2
                                    </small>
                                </label>
                            </div>

                            <!-- Form 2 -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="selected_form"
                                       id="form2" value="form2" autocomplete="off" required>
                                <label class="btn btn-outline-primary p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                       for="form2">
                                    <i class="fas fa-user-graduate fa-3x mb-3 text-primary"></i>
                                    <h5>Form 2</h5>
                                    <p class="mb-1 text-success fw-bold">Class 3 to 10</p>
                                    <small class="text-muted text-center">
                                        Complete details with additional information
                                    </small>
                                </label>
                            </div>

                            <!-- Form 3 -->
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="selected_form"
                                       id="form3" value="form3" autocomplete="off" required>
                                <label class="btn btn-outline-primary p-4 w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                       for="form3">
                                    <i class="fas fa-university fa-3x mb-3 text-primary"></i>
                                    <h5>Form 3</h5>
                                    <p class="mb-1 text-success fw-bold">Higher Secondary</p>
                                    <small class="text-muted text-center">
                                        11th-12th with stream selection
                                    </small>
                                </label>
                            </div>
                        </div>

                        @error('selected_form')
                            <div class="text-danger text-center mt-3">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="fas fa-arrow-right me-2"></i>
                                Proceed to Selected Form
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>
                            Back to Home Page
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
    .btn-check:checked + .btn-outline-primary {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: scale(1.02);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-outline-primary {
        border-radius: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
    }

    .btn-outline-primary:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endsection
