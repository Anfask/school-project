@foreach($notifications as $notification)
    @php
        $notificationData = $notification->data;
        $isRead = $notification->read_at !== null;
    @endphp

    <div class="list-group-item list-group-item-action {{ !$isRead ? 'bg-light' : '' }} mb-2 rounded border" id="notification-{{ $notification->id }}">
        <div class="d-flex w-100 justify-content-between align-items-start">
            <div class="flex-grow-1 mr-3">
                <div class="d-flex align-items-center mb-1">
                    @switch($notificationData['type'] ?? 'info')
                        @case('success')
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            @break
                        @case('warning')
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                            @break
                        @case('error')
                        @case('danger')
                            <i class="fas fa-times-circle text-danger mr-2"></i>
                            @break
                        @default
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                    @endswitch

                    <h6 class="mb-0 {{ !$isRead ? 'font-weight-bold' : '' }}">
                        {{ $notificationData['title'] ?? 'Notification' }}
                    </h6>
                </div>

                <p class="mb-1 text-gray-600">
                    {{ $notificationData['message'] ?? 'No message provided.' }}
                </p>

                <small class="text-muted">
                    <i class="far fa-clock mr-1"></i>
                    {{ $notification->created_at->diffForHumans() }}

                    @if(isset($notificationData['context']))
                        <span class="mx-2">•</span>
                        <span class="badge badge-secondary">{{ $notificationData['context'] }}</span>
                    @endif
                </small>
            </div>

            <div class="notification-actions">
                @if(!$isRead)
                    <button class="btn btn-sm btn-outline-success mark-as-read" data-id="{{ $notification->id }}">
                        <i class="fas fa-check"></i> Mark as Read
                    </button>
                @endif
                <button class="btn btn-sm btn-outline-danger delete-notification" data-id="{{ $notification->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        @if(isset($notificationData['url']) && isset($notificationData['action_text']))
            <div class="mt-3">
                <a href="{{ $notificationData['url'] }}" class="btn btn-sm btn-primary">
                    {{ $notificationData['action_text'] }}
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif
    </div>
@endforeach

@if($notifications->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-bell-slash fa-3x text-gray-300 mb-3"></i>
        <h5 class="text-gray-500">No notifications found</h5>
        <p class="text-muted">Try changing your filter settings.</p>
    </div>
@endif
