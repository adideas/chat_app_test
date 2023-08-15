<?php

namespace App\Notifications;

use Adideas\ChatApp\Contract\ChatAppMessage;
use Adideas\ChatApp\Contract\ChatAppNotify;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification implements ChatAppNotify, ShouldQueue
{
    use Queueable;

    public function __construct(protected ChatAppMessage $message)
    {
    }

    public function via(object $notifiable): array
    {
        return ['chatApp'];
    }

    public function toChatApp(object $subject): string
    {
        return $this->getMessage()->getBody();
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
