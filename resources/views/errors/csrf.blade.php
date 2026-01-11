@extends('layouts.app')

@section('title', 'Session Expired')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Session Expired</h4>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-5x text-danger mb-4"></i>
                        <h3 class="text-danger">Your session has expired</h3>
                        <p class="text-muted">{{ $message ?? 'The page has been inactive for too long. Please refresh and try again.' }}</p>
                    </div>

                    <div class="d-grid gap-2 col-md-6 mx-auto">
                        <button onclick="window.location.reload()" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Refresh Page
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>
                    </div>

                    <div class="mt-4 text-muted small">
                        <p>If the problem persists, try:</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success me-2"></i>Clear browser cache</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Enable cookies</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Disable browser extensions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update CSRF token after page loads
    document.addEventListener('DOMContentLoaded', function() {
        const newToken = '{{ $refresh_token ?? csrf_token() }}';
        if (newToken) {
            // Update meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                metaTag.content = newToken;
            }

            // Update global variable
            if (window.CSRF_TOKEN) {
                window.CSRF_TOKEN = newToken;
            }

            // Update all hidden _token inputs
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = newToken;
            });
        }
    });
</script>
@endsection
