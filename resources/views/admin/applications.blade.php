@extends('admin.layout')

@section('title', 'Applications')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 1rem;
    }
    .filter-section {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .table-card {
        border-radius: 1rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    .status-badge {
        padding: 0.5em 1em;
        border-radius: 50rem;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .action-btn-group {
        background: white;
        border-radius: 0.5rem;
        padding: 2px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .avatar-placeholder {
        width: 40px; 
        height: 40px; 
        background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
        color: #999;
    }
</style>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h1 class="h3 fw-bold mb-0 text-gray-800">
            <i class="fas fa-file-alt text-primary me-2"></i>Applications
            <span class="badge bg-primary rounded-pill ms-2 fs-6 align-middle">{{ $applications->total() ?? 0 }}</span>
        </h1>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button class="btn btn-white shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-filter text-muted me-2"></i>Quick Filter
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => '']) }}">All ({{ $statusCounts['total'] ?? 0 }})</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">
                <span class="badge bg-warning text-dark me-2">●</span>Pending ({{ $statusCounts['pending'] ?? 0 }})
            </a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'accepted']) }}">
                <span class="badge bg-success me-2">●</span>Accepted ({{ $statusCounts['accepted'] ?? 0 }})
            </a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}">
                <span class="badge bg-danger me-2">●</span>Rejected ({{ $statusCounts['rejected'] ?? 0 }})
            </a></li>
        </ul>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="filter-section shadow-sm mb-4">
    <form method="GET" action="{{ route('admin.applications') }}">
        <div class="row g-3">
            <!-- Row 1: Basic Filters -->
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" name="search"
                        placeholder="Name, email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">Form Type</label>
                <select class="form-select" name="form_type">
                    <option value="">All Forms</option>
                    <option value="form1" {{ request('form_type') == 'form1' ? 'selected' : '' }}>Form 1 (Pre-Primary - 2nd)</option>
                    <option value="form2" {{ request('form_type') == 'form2' ? 'selected' : '' }}>Form 2 (3rd - 10th)</option>
                    <option value="form3" {{ request('form_type') == 'form3' ? 'selected' : '' }}>Form 3 (11th & 12th)</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">Class</label>
                <select class="form-select" name="class">
                    <option value="">All Classes</option>
                    @if(isset($classes) && is_array($classes))
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">Status</label>
                <select class="form-select" name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Row 2: Date and Actions -->
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">From Date</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label small text-muted fw-bold text-uppercase">To Date</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-lg-6 col-md-12 d-flex align-items-end">
                <div class="d-flex w-100 gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.applications') }}" class="btn btn-light border flex-grow-1">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                    <button type="submit" name="export" value="true" class="btn btn-success text-white flex-grow-1">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Applications Table -->
<div class="card table-card mb-4">
    <div class="card-body p-0">
        @if($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4">ID</th>
                            <th>Student</th>
                            <th>Contact</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Applied</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($applications as $app)
                            <tr>
                                <td class="ps-4 text-muted fw-bold">#{{ $app->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 position-relative">
                                            @php
                                                $photoPath = $app->passport_photo_path ?? $app->student_photo_path;
                                                $photoUrl = $photoPath ? Storage::url($photoPath) : null;
                                            @endphp
                                            @if($photoUrl)
                                                <a href="{{ route('admin.application.view', $app->id) }}">
                                                    <img src="{{ $photoUrl }}" alt="Student" class="rounded-circle shadow-sm"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                </a>
                                            @else
                                                <a href="{{ route('admin.application.view', $app->id) }}" class="text-decoration-none">
                                                    <div class="rounded-circle avatar-placeholder d-flex align-items-center justify-content-center">
                                                        <span class="text-secondary fw-bold" style="font-size: 1.2rem;">
                                                            {{ strtoupper(substr($app->first_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </a>
                                            @endif
                                            @if($app->created_at->diffInDays(now()) < 1)
                                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                    <span class="visually-hidden">New</span>
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $app->first_name }} {{ $app->surname }}</div>
                                            <div class="small text-muted">{{ $app->form_type ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column small">
                                        <a href="mailto:{{ $app->email }}" class="text-decoration-none text-muted mb-1">
                                            <i class="fas fa-envelope me-2 text-primary"></i>{{ $app->email }}
                                        </a>
                                        <a href="tel:{{ $app->mobile_1 ?? ($app->mobile_2 ?? '') }}" class="text-decoration-none text-muted">
                                            <i class="fas fa-phone me-2 text-success"></i>{{ $app->mobile_1 ?? ($app->mobile_2 ?? 'N/A') }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $app->admission_sought_for_class ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if($app->status == 'accepted' || $app->status == 'approved')
                                        <span class="status-badge bg-success bg-opacity-10 text-success">Accepted</span>
                                    @elseif($app->status == 'rejected')
                                        <span class="status-badge bg-danger bg-opacity-10 text-danger">Rejected</span>
                                    @elseif($app->status == 'reviewed')
                                        <span class="status-badge bg-info bg-opacity-10 text-info">Reviewed</span>
                                    @else
                                        <span class="status-badge bg-warning bg-opacity-10 text-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    <i class="far fa-clock me-1"></i>{{ $app->created_at->format('d M, Y') }}<br>
                                    <span class="text-xs">{{ $app->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="action-btn-group d-inline-flex border">
                                        <a href="{{ route('admin.application.view', $app->id) }}"
                                            class="btn btn-sm btn-link text-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.application.download', $app->id) }}"
                                            class="btn btn-sm btn-link text-success" title="Download PDF">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <div class="vr my-1 text-muted"></div>
                                        @if($app->status == 'pending' || $app->status == 'reviewed')
                                            <button type="button" class="btn btn-sm btn-link text-success" title="Accept"
                                                onclick="updateStatus({{ $app->id }}, 'accepted')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-link text-danger" title="Reject"
                                                onclick="updateStatus({{ $app->id }}, 'rejected')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center p-3 border-top bg-light">
                <div class="small text-muted">
                    Showing <span class="fw-bold">{{ $applications->firstItem() }}</span> to <span class="fw-bold">{{ $applications->lastItem() }}</span> of
                    <span class="fw-bold">{{ $applications->total() }}</span> entries
                </div>
                <div>
                    {{ $applications->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-inbox fa-2x text-muted"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-secondary">No applications found</h5>
                <p class="text-muted small">
                    @if(request()->hasAny(['search', 'status', 'class']))
                        Try adjusting your filters to see results.
                    @else
                        New applications will appear here once submitted.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'class']))
                    <a href="{{ route('admin.applications') }}" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="fas fa-sync me-1"></i> Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Status Update Form (Hidden) -->
<form id="status-form" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="status" id="status-input">
</form>

@push('scripts')
    <script>
        function updateStatus(applicationId, status) {
            if (!confirm(`Are you sure you want to mark this application as ${status}?`)) {
                return;
            }

            const form = document.getElementById('status-form');
            form.action = `/admin/application/${applicationId}/status`;
            document.getElementById('status-input').value = status;
            form.submit();
        }
    </script>
@endpush
@endsection