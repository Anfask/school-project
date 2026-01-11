@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
        <div class="d-flex">
            <button id="mark-all-read" class="btn btn-success mr-2">
                <i class="fas fa-check-circle"></i> Mark All as Read
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Notifications</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item filter-notifications" href="#" data-filter="all">All Notifications</a>
                    <a class="dropdown-item filter-notifications" href="#" data-filter="unread">Unread Only</a>
                    <a class="dropdown-item filter-notifications" href="#" data-filter="read">Read Only</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($notifications->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">No notifications yet</h5>
                    <p class="text-muted">When you have notifications, they'll appear here.</p>
                </div>
            @else
                <div class="list-group" id="notifications-list">
                    @include('admin.notifications.partials.notifications-list')
                </div>

                @if($notifications->hasPages())
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Mark single notification as read
    $(document).on('click', '.mark-as-read', function() {
        const button = $(this);
        const notificationId = button.data('id');
        const notificationItem = button.closest('.list-group-item');

        $.ajax({
            url: '{{ route("admin.notifications.read", ["notification" => "__ID__"]) }}'.replace('__ID__', notificationId),
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    notificationItem.removeClass('bg-light');
                    button.closest('.notification-actions').remove();
                    updateNotificationCount();
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert('Failed to mark notification as read. Please try again.');
            }
        });
    });

    // Mark all notifications as read
    $('#mark-all-read').click(function() {
        if (confirm('Are you sure you want to mark all notifications as read?')) {
            $.ajax({
                url: '{{ route("admin.notifications.mark-all-read") }}',
                method: 'POST',
                success: function(response) {
                    if (response.success) {
                        $('.mark-as-read').closest('.notification-actions').remove();
                        $('.list-group-item').removeClass('bg-light');
                        updateNotificationCount();
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to mark all notifications as read. Please try again.');
                }
            });
        }
    });

    // Delete notification
    $(document).on('click', '.delete-notification', function() {
        if (confirm('Are you sure you want to delete this notification?')) {
            const button = $(this);
            const notificationId = button.data('id');
            const notificationItem = button.closest('.list-group-item');

            $.ajax({
                url: '{{ route("admin.notifications.delete", ["notification" => "__ID__"]) }}'.replace('__ID__', notificationId),
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        notificationItem.fadeOut(300, function() {
                            $(this).remove();
                            if ($('#notifications-list .list-group-item').length === 0) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Failed to delete notification. Please try again.');
                }
            });
        }
    });

    // Filter notifications
    $('.filter-notifications').click(function(e) {
        e.preventDefault();
        const filter = $(this).data('filter');

        // Update active filter
        $('.filter-notifications').removeClass('active');
        $(this).addClass('active');

        // Reload notifications with filter
        loadNotifications(filter);
    });

    function loadNotifications(filter = 'all') {
        $.ajax({
            url: '{{ route("admin.notifications.index") }}',
            method: 'GET',
            data: { filter: filter },
            success: function(data) {
                $('#notifications-list').html(data);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    function updateNotificationCount() {
        $.ajax({
            url: '{{ route("admin.notifications.count.unread") }}',
            method: 'GET',
            success: function(data) {
                // Update count in navbar if exists
                const badge = $('#notification-badge');
                if (badge.length) {
                    if (data.count > 0) {
                        badge.text(data.count).show();
                    } else {
                        badge.hide();
                    }
                }
            }
        });
    }

    // Auto-refresh notifications every 30 seconds
    setInterval(() => {
        const activeFilter = $('.filter-notifications.active').data('filter') || 'all';
        loadNotifications(activeFilter);
        updateNotificationCount();
    }, 30000);
});
</script>
@endpush
