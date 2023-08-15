<?php

namespace App\Listeners;

use Adideas\ChatApp\ChatApp\Events\EventMessageStatus;
use Adideas\ChatApp\Events\EventCreateTaskSend;
use Adideas\ChatApp\Events\EventNotCreateTaskSend;
use App\Models\PivotMessagePhone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatAppNotCreateTaskListener
{
    public function handle(EventNotCreateTaskSend $event): void
    {
        PivotMessagePhone::where(PivotMessagePhone::MESSAGE_UUID, $event->getMessage()->getIdentify())
            ->where(PivotMessagePhone::PHONE_UUID, $event->getSubject()->getIdentify())
            ->update([
                'status' => 'error',
                'error_message' => $event->getErrorMessage()
            ]);
    }
}
