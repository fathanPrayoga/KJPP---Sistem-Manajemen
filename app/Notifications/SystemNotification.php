<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public $message;
    public $type;
    public $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $type = 'info', $actionUrl = null)
    {
        $this->message = $message;
        $this->type = $type;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'action_url' => $this->actionUrl,
        ];
    }
}
