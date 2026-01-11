@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '!')

@section('content')
<style>
    .stat-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stat-card .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        min-height: 150px;
        justify-content: center;
    }

    .stat-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .stat-card .count {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-card .label {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0.9;
    }

    .stat-card.total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card.todo {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-card.done {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .stat-card.in-progress {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
</style>

<div class="row fade-in">
    <!-- Stats Cards -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card total">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="count">{{ $stats['total'] ?? 0 }}</div>
                <div class="label">Total Applications</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card todo">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="count">{{ $stats['pending'] ?? 0 }}</div>
                <div class="label">Pending Review</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card done">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="count">{{ $stats['reviewed'] ?? 0 }}</div>
                <div class="label">Reviewed</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card in-progress">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="count">{{ $stats['accepted'] ?? 0 }}</div>
                <div class="label">Accepted</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="count">{{ $stats['rejected'] ?? 0 }}</div>
                <div class="label">Rejected</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="card-body">
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="count">{{ $stats['today'] ?? 0 }}</div>
                <div class="label">Today</div>
            </div>
        </div>
    </div>
</div>

<div class="row fade-in">
    <!-- Form Type Distribution -->
    <div class="col-xl-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie me-2"></i> Form Type Distribution</h5>
            </div>
            <div class="card-body">
                <canvas id="formTypeChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Classes -->
    <div class="col-xl-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-school me-2"></i> Top Classes</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($topClasses as $class)
                    <div class="list-group-item border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                            <strong>
                                @if($class->form_type == 'form1')
                                    {{ $class->class_name ?? 'Pre-primary' }}
                                @elseif($class->form_type == 'form2' || $class->form_type == 'form3')
                                    {{ $class->class_name ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </strong>
                            <small class="text-muted ms-2">
                                ({{ $class->form_type == 'form1' ? 'Form 1' : ($class->form_type == 'form2' ? 'Form 2' : ($class->form_type == 'form3' ? 'Form 3' : 'N/A')) }})
                            </small>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $class->total }}</span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-school fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No class data available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Applications Chart -->
    <div class="col-xl-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-line me-2"></i> Monthly Applications</h5>
            </div>
            <div class="card-body">
                <canvas id="applicationsChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Applications -->
<div class="row fade-in">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i> Recent Applications</h5>
                <a href="{{ route('admin.applications') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye me-1"></i> View All
                </a>
            </div>
            <div class="card-body">
                @if($recentApplications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Form Type</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $application)
                            <tr>
                                <td>#{{ $application->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 36px; height: 36px;">
                                            {{ strtoupper(substr($application->first_name ?? $application->student_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $application->full_name ?? ($application->first_name . ' ' . $application->surname) }}</strong><br>
                                            <small class="text-muted">{{ $application->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge
                                        @if($application->form_type == 'form1') bg-info
                                        @elseif($application->form_type == 'form2') bg-success
                                        @elseif($application->form_type == 'form3') bg-warning
                                        @else bg-secondary @endif">
                                        @if($application->form_type == 'form1') Form 1
                                        @elseif($application->form_type == 'form2') Form 2
                                        @elseif($application->form_type == 'form3') Form 3
                                        @else N/A @endif
                                    </span>
                                </td>
                                <td>
                                    @if($application->form_type == 'form1')
                                        {{ $application->admission_sought_for_class ?? 'N/A' }}
                                    @elseif(in_array($application->form_type, ['form2', 'form3']))
                                        {{ $application->admission_class ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($application->status == 'accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif($application->status == 'reviewed')
                                        <span class="badge bg-info">Reviewed</span>
                                    @elseif($application->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.application.view', $application->id) }}"
                                           class="btn btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.application.download', $application->id) }}"
                                           class="btn btn-outline-success" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No applications yet</h5>
                    <p class="text-muted">When applications are submitted, they'll appear here.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Applications Chart
    const ctx = document.getElementById('applicationsChart').getContext('2d');
    const monthlyData = @json($monthlyStats ?? []);

    const labels = monthlyData.map(item => {
        const [year, month] = item.month.split('-');
        return new Date(year, month - 1).toLocaleString('default', { month: 'short' });
    });

    const data = monthlyData.map(item => item.count);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Applications',
                data: data,
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Form Type Chart
    const formTypeCtx = document.getElementById('formTypeChart').getContext('2d');
    const formTypeData = @json($formTypeStats ?? []);

    const formTypeLabels = formTypeData.map(item => {
        if (item.form_type === 'form1') return 'Form 1 (Pre-primary to Class 2)';
        if (item.form_type === 'form2') return 'Form 2 (Class 3 to 10)';
        if (item.form_type === 'form3') return 'Form 3 (Higher Secondary)';
        return 'Other';
    });

    const formTypeCounts = formTypeData.map(item => item.count);
    const formTypeColors = ['#4361ee', '#06d6a0', '#ffd166', '#ef476f'];

    new Chart(formTypeCtx, {
        type: 'doughnut',
        data: {
            labels: formTypeLabels,
            datasets: [{
                data: formTypeCounts,
                backgroundColor: formTypeColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            cutout: '60%'
        }
    });
});
</script>
@endpush
@endsection
