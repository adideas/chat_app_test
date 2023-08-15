<?php

namespace Tests\ChatApp\WebHook;

use Adideas\ChatApp\ChatApp\WebHook\LoaderWebHook;
use Adideas\ChatApp\Events\EventMessageStatusDelivery;
use Adideas\ChatApp\Events\EventMessageStatusSend;
use Adideas\ChatApp\Events\EventMessageStatusView;
use PHPUnit\Framework\TestCase;

class LoaderWebHookTest extends TestCase
{
    public function testLoader() {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'messageStatus.json');
        $meta = new LoaderWebHook(json_decode($json, true));
        $events = $meta->getEvents()->toArray();

        self::assertEquals(
            array_map(fn($i) => get_class($i), array_values($events)),
            [
                EventMessageStatusSend::class,
                EventMessageStatusView::class,
                EventMessageStatusDelivery::class,
            ]
        );

        self::assertEquals([
            'BAE5DD2EFC88B3C6',
            'BAE50969AD3BEA0F',
            'BAE50969AD3BEA0F',
        ], array_map(fn($i) => $i->getId(), array_values($events)));
    }
}
