<?php

namespace Adideas\ChatApp\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class EventMessageStatusView extends EventMessageStatus
{
    use InteractsWithSockets, SerializesModels;
    public static string $type = 'viewed';
}
