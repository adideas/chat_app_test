<?php

namespace Adideas\ChatApp\ChatApp\WebHook;

use Adideas\ChatApp\Events\EventMessageStatus;
use Adideas\ChatApp\Events\EventMessageStatusDelivery;
use Adideas\ChatApp\Events\EventMessageStatusSend;
use Adideas\ChatApp\Events\EventMessageStatusView;
use Adideas\ChatApp\Events\EventRaw;
use Illuminate\Database\Eloquent\Collection;

class LoaderWebHook
{
    protected string $type;
    protected int $licenseId;
    protected string $messengerType;

    public function __construct(protected array $request)
    {
        $meta = $request['meta'];
        $this->type = $meta['type'] ?? 'messageStatus';
        $this->licenseId = $meta['licenseId'] ?? 0;
        $this->messengerType = $meta['messengerType'] ?? 'grWhatsApp';
    }

    public function getEvents(): Collection
    {
        $interfaces = [
            'messageStatus' => [LoaderWebHook::class, 'messageStatus']
        ][$this->type] ?? [LoaderWebHook::class, 'rawEvents'];

        return $interfaces($this->request['data'] ?? []);
    }

    public static function rawEvents(array $data = []): Collection
    {
        $events = new Collection();

        foreach ($data as $item) {
            $events->add(new EventRaw($item));
        }

        return $events;
    }

    public static function messageStatus(array $data = []): Collection
    {
        $types = [
            EventMessageStatusSend::$type => EventMessageStatusSend::class,
            EventMessageStatusView::$type => EventMessageStatusView::class,
            EventMessageStatusDelivery::$type => EventMessageStatusDelivery::class,
        ];

        $events = new Collection();

        foreach ($data as $item) {
            $interfaces = $types[$item['type'] ?? ''] ?? EventMessageStatus::class;
            $events->add(new $interfaces($item));
        }

        return $events;
    }

}
