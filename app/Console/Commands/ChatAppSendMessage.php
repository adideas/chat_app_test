<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Phone;
use App\Models\PivotMessagePhone;
use App\Notifications\MessageNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class ChatAppSendMessage extends Command
{
    protected $signature = 'app:chat-app-send-message';

    protected $description = 'Отправку сообщений сделать на очередях с случайной задержкой 5-50 секунд.';

    public function handle()
    {
        $query = PivotMessagePhone::whereNull('reserved_at');
        $chunk = 100;
        $offset = 0;
        $count = $query->count();

        for (;$offset < $count; $offset += $chunk) {
            $query
                ->with(['phone' => fn(HasOne $hasOne) => $hasOne->select(['uuid', 'phone'])])
                ->with(['message' => fn(HasOne $hasOne) => $hasOne->select(['uuid', 'body'])])
                ->offset($offset)
                ->limit($chunk)
                ->get()
                ->each(function (PivotMessagePhone $pivotMessagePhone) {
                    /** @var Phone $phone */
                    $phone = $pivotMessagePhone->phone;
                    /** @var Message $message */
                    $message = $pivotMessagePhone->message;

                    $phone->notify(
                        (new MessageNotification($message))
                            ->delay($this->getNextTime())
                    );

                    PivotMessagePhone::where(PivotMessagePhone::MESSAGE_UUID, $message->getIdentify())
                        ->where(PivotMessagePhone::PHONE_UUID, $message->getIdentify())
                        ->update(['reserved_at' => time()]);
                });

            $count = $query->count();
        }
    }

    private function getNextTime(): Carbon
    {
        $timestamp = Cache::get(__CLASS__, time() + rand(5, 50));
        if ($timestamp < time()) {
            $timestamp = time();
        }

        $timestamp += rand(5, 50);

        Cache::put(__CLASS__, $timestamp);

        return Carbon::createFromTimestamp($timestamp);
    }
}
