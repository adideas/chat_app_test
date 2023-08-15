<?php

namespace App\Http\Flyway\Message;

use Illuminate\Http\Request;

class MessageDTO extends MessageSimpleFlyway implements MessageFlyway
{
    public function __construct(Request $request)
    {
        $this->body = $request->input('body', '');
    }
}
