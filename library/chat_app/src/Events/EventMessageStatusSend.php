<?php

namespace Adideas\ChatApp\Events;

class EventMessageStatusSend extends EventMessageStatus
{
    public static string $type = 'sent';
}
