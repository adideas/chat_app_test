<?php

namespace Adideas\ChatApp\Events;

use Adideas\ChatApp\ChatApp\Contract\EventWebHook;
use Adideas\ChatApp\Contract\ChatAppMessage;
use Adideas\ChatApp\Contract\ChatAppPhone;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class EventCreateTaskSend
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(
        protected ChatAppPhone $subject,
        protected ChatAppMessage $message,
        protected ?string $tokenMessage = null
    )
    {
    }

    public function getSubject(): ChatAppPhone
    {
        return $this->subject;
    }

    public function getMessage(): ChatAppMessage
    {
        return $this->message;
    }

    public function getTokenMessage(): ?string
    {
        return $this->tokenMessage;
    }
}
