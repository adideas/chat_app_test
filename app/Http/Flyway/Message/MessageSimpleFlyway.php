<?php

namespace App\Http\Flyway\Message;

use App\Models\Message;

class MessageSimpleFlyway implements MessageFlyway
{
    protected string $uuid = '';
    protected string $body = '';
    protected ?int $created_at = 0;
    protected ?int $updated_at = 0;

    public function __construct(?Message $message = null)
    {
        if ($message) {
            $this->uuid = $message->getIdentify();
            $this->body = $message->getBody();
            $this->created_at = $message->getAttribute($message->getCreatedAtColumn());
            $this->updated_at = $message->getAttribute($message->getUpdatedAtColumn());
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updated_at;
    }

    public function __toString(): string
    {
        return json_encode([
            'uuid' => $this->uuid,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }
}
