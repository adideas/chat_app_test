<?php

namespace Adideas\ChatApp\Events;

use Adideas\ChatApp\ChatApp\Contract\EventWebHook;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

abstract class EventMessageStatus implements EventWebHook
{
    use InteractsWithSockets, SerializesModels;

    public static string $type = '';

    protected ?string $id = null;
    protected ?int $time = null;
    protected ?string $error = null;

    public function __construct(array $request)
    {
        $this->id = $request['id'] ?? null;
        $this->time = $request['time'] ?? null;
        $this->error = $request['error'] ?? null;

        if (!static::$type) {
            static::$type = $request['type'] ?? null;
        }
    }

    public function __invoke()
    {
    }

    public function getRequest(): array
    {
        return [];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function isError(): bool
    {
        return !!$this->error;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getType(): string
    {
        return static::$type;
    }
}
