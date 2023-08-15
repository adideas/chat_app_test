<?php

namespace App\Listeners;

use Adideas\ChatApp\ChatApp\Events\EventMessageStatus;
use Adideas\ChatApp\Events\EventCreateTaskSend;
use App\Models\PivotMessagePhone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatAppCreateTaskListener
{
    public function handle(EventCreateTaskSend $event): void
    {
        PivotMessagePhone::where(PivotMessagePhone::MESSAGE_UUID, $event->getMessage()->getIdentify())
            ->where(PivotMessagePhone::PHONE_UUID, $event->getSubject()->getIdentify())
            ->update(['token_message' => $event->getTokenMessage()]);
    }
}
