<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $message;
    public $type;
    public $actionUrl;
    public $actionText;
    public $priority;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        string $subject,
        string $message,
        string $type = 'info',
        string $actionUrl = null,
        string $actionText = null,
        string $priority = 'normal'
    ) {
        $this->subject = $subject;
        $this->message = $message;
        $this->type = $type;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->priority = $priority;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('🔔 ' . $this->subject . ' - ' . config('app.name'))
            ->view('emails.admin-notification', [
                'subject' => $this->subject,
                'message' => $this->message,
                'type' => $this->type,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
                'priority' => $this->priority,
                'admin' => $notifiable,
                'timestamp' => now()->format('F j, Y g:i A'),
                'appName' => config('app.name'),
                'currentYear' => date('Y'),
            ]);

        // Add priority headers if high priority
        if ($this->priority === 'high') {
            $mailMessage->priority(1);
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
            'type' => $this->type,
            'action_url' => $this->actionUrl,
            'action_text' => $this->actionText,
            'priority' => $this->priority,
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get notification type icon
     */
    public function getIcon(): string
    {
        $icons = [
            'success' => '✅',
            'warning' => '⚠️',
            'error' => '❌',
            'info' => 'ℹ️',
            'security' => '🔒',
            'system' => '⚙️',
            'user' => '👤',
            'application' => '📄',
        ];

        return $icons[$this->type] ?? '📧';
    }

    /**
     * Get priority color
     */
    public function getPriorityColor(): string
    {
        $colors = [
            'high' => '#dc3545',
            'normal' => '#17a2b8',
            'low' => '#6c757d',
        ];

        return $colors[$this->priority] ?? '#17a2b8';
    }

    /**
     * Get type color
     */
    public function getTypeColor(): string
    {
        $colors = [
            'success' => '#28a745',
            'warning' => '#ffc107',
            'error' => '#dc3545',
            'info' => '#17a2b8',
            'security' => '#6610f2',
            'system' => '#6f42c1',
            'user' => '#20c997',
            'application' => '#fd7e14',
        ];

        return $colors[$this->type] ?? '#17a2b8';
    }
}
