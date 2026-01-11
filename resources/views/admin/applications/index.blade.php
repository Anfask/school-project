@extends('admin.layout')

@section('title', 'Applications')
@section('page-title', 'Applications Management')
@section('page-subtitle', 'Manage all admission applications')

@section('content')
<div class="row fade-in">
    <div class="col-12">
        <!-- Filters Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.applications') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Name, email, phone, application no...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Form Type</label>
                            <select class="form-select" name="form_type">
                                <option value="">All Forms</option>
                                <option value="form1" {{ request('form_type') == 'form1' ? 'selected' : '' }}>Form 1</option>
                                <option value="form2" {{ request('form_type') == 'form2' ? 'selected' : '' }}>Form 2</option>
                                <option value="form3" {{ request('form_type') == 'form3' ? 'selected' : '' }}>Form 3</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Class</label>
                            <input type="text" class="form-control" name="class"
                                   value="{{ request('class') }}"
                                   placeholder="Class name">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="date_from"
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="date_to"
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applications Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i> Applications List
                    <span class="badge bg-primary ms-2">{{ $applications->total() }}</span>
                </h5>
                <div class="btn-group">
                    <button class="btn btn-info btn-sm" id="bulkReviewBtn">
                        <i class="fas fa-eye me-1"></i> Mark as Reviewed
                    </button>
                    <button class="btn btn-success btn-sm" id="bulkAcceptBtn">
                        <i class="fas fa-check me-1"></i> Accept Selected
                    </button>
                    <button class="btn btn-danger btn-sm" id="bulkRejectBtn">
                        <i class="fas fa-times me-1"></i> Reject Selected
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($applications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="applicationsTable">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>App No</th>
                                <th>Student</th>
                                <th>Form Type</th>
                                <th>Class</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $app)
                            <tr>
                                <td>
                                    <input type="checkbox" class="select-app" value="{{ $app->id }}">
                                </td>
                                <td>
                                    #{{ $app->id }}
                                    @if($app->application_number)
                                    <br><small class="text-muted">{{ $app->application_number }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 36px; height: 36px;">
                                            {{ strtoupper(substr($app->first_name ?? $app->student_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $app->full_name ?? ($app->first_name . ' ' . $app->surname) }}</strong><br>
                                            <small class="text-muted">{{ $app->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge
                                        @if($app->form_type == 'form1') bg-info
                                        @elseif($app->form_type == 'form2') bg-success
                                        @elseif($app->form_type == 'form3') bg-warning
                                        @else bg-secondary @endif">
                                        @if($app->form_type == 'form1') Form 1
                                        @elseif($app->form_type == 'form2') Form 2
                                        @elseif($app->form_type == 'form3') Form 3
                                        @else N/A @endif
                                    </span>
                                </td>
                                <td>
                                    @if($app->form_type == 'form1')
                                        {{ $app->admission_sought_for_class ?? 'N/A' }}
                                    @elseif(in_array($app->form_type, ['form2', 'form3']))
                                        {{ $app->admission_class ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        <i class="fas fa-phone text-muted me-1"></i>
                                        {{ $app->phone_no1 ?? $app->mobile_1 ?? 'N/A' }}<br>
                                        @if($app->phone_no2 || $app->mobile_2)
                                        <i class="fas fa-phone-alt text-muted me-1"></i>
                                        {{ $app->phone_no2 ?? $app->mobile_2 }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($app->status == 'accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif($app->status == 'reviewed')
                                        <span class="badge bg-info">Reviewed</span>
                                    @elseif($app->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.application.view', $app->id) }}"
                                           class="btn btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.application.download', $app->id) }}"
                                           class="btn btn-outline-success" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button class="btn btn-outline-warning quick-status"
                                                data-id="{{ $app->id }}"
                                                data-status="{{ $app->status }}"
                                                title="Quick Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }}
                        of {{ $applications->total() }} entries
                    </div>
                    <div>
                        {{ $applications->links() }}
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No applications found</h5>
                    <p class="text-muted">
                        @if(request()->anyFilled(['search', 'form_type', 'status', 'class', 'date_from', 'date_to']))
                            Try adjusting your filters
                        @else
                            No applications have been submitted yet
                        @endif
                    </p>
                    @if(request()->anyFilled(['search', 'form_type', 'status', 'class', 'date_from', 'date_to']))
                    <a href="{{ route('admin.applications') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-1"></i> Clear Filters
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Status Modal -->
<div class="modal fade" id="quickStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Application Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickStatusForm">
                    @csrf
                    <input type="hidden" name="application_id" id="application_id">

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="quick_status" required>
                            <option value="pending">Pending</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control" name="remarks" id="quick_remarks"
                                  rows="3" placeholder="Add remarks (optional)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveQuickStatus">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#applicationsTable').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: true,
        order: [[1, 'desc']],
        language: {
            emptyTable: "No applications found"
        }
    });

    // Select all functionality
    $('#selectAll').change(function() {
        $('.select-app').prop('checked', $(this).prop('checked'));
    });

    // Bulk actions
    $('#bulkReviewBtn').click(function() {
        bulkUpdateStatus('reviewed');
    });

    $('#bulkAcceptBtn').click(function() {
        bulkUpdateStatus('accepted');
    });

    $('#bulkRejectBtn').click(function() {
        bulkUpdateStatus('rejected');
    });

    function bulkUpdateStatus(status) {
        const selectedIds = $('.select-app:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one application.');
            return;
        }

        if (!confirm(`Are you sure you want to mark ${selectedIds.length} application(s) as ${status}?`)) {
            return;
        }

        $.ajax({
            url: '{{ route("admin.applications.bulk-update") }}',
            method: 'POST',
            data: {
                ids: selectedIds,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    }

    // Quick status update
    $('.quick-status').click(function() {
        const appId = $(this).data('id');
        const currentStatus = $(this).data('status');

        $('#application_id').val(appId);
        $('#quick_status').val(currentStatus);
        $('#quick_remarks').val('');

        $('#quickStatusModal').modal('show');
    });

    $('#saveQuickStatus').click(function() {
        const appId = $('#application_id').val();

        // Create the URL correctly
        const url = '{{ url("admin/application") }}/' + appId + '/status';

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: $('#quick_status').val(),
                remarks: $('#quick_remarks').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#quickStatusModal').modal('hide');

                    // Update the UI without reloading
                    const row = $('.quick-status[data-id="' + appId + '"]').closest('tr');
                    const statusBadge = row.find('.badge');
                    const quickBtn = row.find('.quick-status');

                    // Update badge
                    statusBadge.removeClass('bg-warning bg-info bg-success bg-danger');

                    // Add appropriate class based on new status
                    if (response.status === 'accepted') {
                        statusBadge.addClass('bg-success').text('Accepted');
                    } else if (response.status === 'reviewed') {
                        statusBadge.addClass('bg-info').text('Reviewed');
                    } else if (response.status === 'rejected') {
                        statusBadge.addClass('bg-danger').text('Rejected');
                    } else {
                        statusBadge.addClass('bg-warning').text('Pending');
                    }

                    // Update button data-status
                    quickBtn.data('status', response.status);

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
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Auto-submit filter form on filter change
    $('select[name="form_type"], select[name="status"]').change(function() {
        $('#filterForm').submit();
    });

    // Handle quick status modal hidden event
    $('#quickStatusModal').on('hidden.bs.modal', function () {
        $('#quickStatusForm')[0].reset();
    });
});
</script>

<style>
.toast {
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection
