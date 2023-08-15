<?php

namespace App\Http\Flyway\Message;

interface MessageFlyway
{
    public function __toString(): string;

    public function getBody(): string;
}
