@extends('admin.layout')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-alt"></i> Application Details
        <span class="fs-6 text-muted">#{{ $application->id }}</span>
    </h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.application.download', $application->id) }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-download"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Application Details -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Personal Information</h5>
                <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($application->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">First Name</label>
                        <p class="fs-5">{{ $application->first_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Surname</label>
                        <p class="fs-5">{{ $application->surname }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Email Address</label>
                        <p class="fs-5">{{ $application->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Phone Number</label>
                        <p class="fs-5">{{ $application->mobile_1 ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Alternate Phone</label>
                        <p class="fs-5">{{ $application->mobile_2 ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Date of Birth</label>
                        <p class="fs-5">{{ $application->dob ? \Carbon\Carbon::parse($application->dob)->format('d M, Y') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Gender</label>
                        <p class="fs-5">{{ ucfirst($application->gender) ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nationality</label>
                        <p class="fs-5">{{ $application->nationality ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($application->address)
                <div class="mb-3">
                    <label class="form-label text-muted">Address</label>
                    <p class="fs-5">{{ $application->address }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Educational Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Educational Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Class Applied For</label>
                        <p class="fs-5">{{ $application->admission_sought_for_class ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Application Number</label>
                        <p class="fs-5">{{ $application->application_number ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($application->previous_school_name)
                <div class="mb-3">
                    <label class="form-label text-muted">Previous School Name</label>
                    <p class="fs-5">{{ $application->previous_school_name }}</p>
                </div>
                @endif

                @if($application->previous_class)
                <div class="mb-3">
                    <label class="form-label text-muted">Previous Class</label>
                    <p class="fs-5">{{ $application->previous_class }}</p>
                </div>
                @endif

                @if($application->father_name)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Father's Name</label>
                        <p class="fs-5">{{ $application->father_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Father's Occupation</label>
                        <p class="fs-5">{{ $application->father_occupation ?? 'N/A' }}</p>
                    </div>
                </div>
                @endif

                @if($application->mother_name)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Mother's Name</label>
                        <p class="fs-5">{{ $application->mother_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Mother's Occupation</label>
                        <p class="fs-5">{{ $application->mother_occupation ?? 'N/A' }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Additional Information -->
        @if($application->additional_info || $application->remarks)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Additional Information</h5>
            </div>
            <div class="card-body">
                @if($application->additional_info)
                <div class="mb-3">
                    <label class="form-label text-muted">Additional Information</label>
                    <p>{{ $application->additional_info }}</p>
                </div>
                @endif

                @if($application->remarks)
                <div class="mb-3">
                    <label class="form-label text-muted">Admin Remarks</label>
                    <div class="alert alert-info">
                        {{ $application->remarks }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar Actions -->
    <div class="col-md-4">
        <!-- Application Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.application.status', $application->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="status" class="form-label">Current Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"
                                  placeholder="Add any remarks or comments...">{{ $application->remarks ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Application Timeline -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Application Timeline</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <div class="d-flex">
                            <div class="timeline-badge bg-success">
                                <i class="fas fa-file-import"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Application Submitted</h6>
                                <small class="text-muted">{{ $application->created_at->format('d M, Y h:i A') }}</small>
                            </div>
                        </div>
                    </li>

                    @if($application->status_updated_at)
                    <li class="mb-3">
                        <div class="d-flex">
                            <div class="timeline-badge bg-info">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Status Updated</h6>
                                <small class="text-muted">{{ $application->status_updated_at->format('d M, Y h:i A') }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if($application->updated_at && $application->updated_at->gt($application->created_at))
                    <li>
                        <div class="d-flex">
                            <div class="timeline-badge bg-secondary">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Last Updated</h6>
                                <small class="text-muted">{{ $application->updated_at->format('d M, Y h:i A') }}</small>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $application->email }}" class="btn btn-outline-primary">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                    @if($application->mobile_1)
                    <a href="tel:{{ $application->mobile_1 }}" class="btn btn-outline-success">
                        <i class="fas fa-phone"></i> Make Call
                    </a>
                    @endif
                    <button class="btn btn-outline-info" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Application
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-badge {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
</style>
@endsection
