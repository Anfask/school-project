@extends('layouts.app')

@section('title', 'Application Submitted')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>

                        <h2 class="mb-3">Application Submitted Successfully!</h2>
                        <p class="text-muted mb-4">Thank you for applying to our school.</p>

                        <div class="alert alert-info mb-4 text-start">
                            <h5>Application Details:</h5>
                            <p><strong>Application ID:</strong> #{{ $admission->id }}</p>
                            <p><strong>Name:</strong> {{ $admission->full_name }}</p>
                            <p><strong>Class:</strong>
                                {{ $admission->admission_sought_for_class ?? $admission->admission_class }}</p>
                            <p><strong>Date:</strong> {{ $admission->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                            <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
                            <a href="{{ route('admission.download', $admission->id) }}"
                                class="btn btn-outline-primary">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection