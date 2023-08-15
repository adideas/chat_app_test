<?php

namespace App\Listeners;

use Adideas\ChatApp\Events\EventMessageStatus;
use App\Models\PivotMessagePhone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatAppMessageStatusListener
{
    public function handle(EventMessageStatus $event): void
    {
        if (PivotMessagePhone::where('token_message', $event->getId())->exists()) {
            $this->update($event);
        }
    }

    private function update(EventMessageStatus $event): void
    {
        if ($event->isError()) {
            PivotMessagePhone::where('token_message', $event->getId())->update([
                'status' => 'error',
                'error_message' => $event->getError()
            ]);
        } else {
            PivotMessagePhone::where('token_message', $event->getId())->update([
                'status' => $event->getType()
            ]);
        }
    }
}
