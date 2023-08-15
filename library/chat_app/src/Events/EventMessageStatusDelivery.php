<?php

namespace Adideas\ChatApp\Events;

class EventMessageStatusDelivery extends EventMessageStatus
{
    public static string $type = 'delivered';
}
