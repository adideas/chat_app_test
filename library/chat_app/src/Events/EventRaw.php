<?php

namespace Adideas\ChatApp\Events;

use Adideas\ChatApp\ChatApp\Contract\EventWebHook;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class EventRaw implements EventWebHook
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(protected ?array $request)
    {
    }

    public function getRequest(): array
    {
        return $this->request;
    }
}
