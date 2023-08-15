<?php

namespace Tests\Http\Controllers;

use Adideas\ChatApp\ChatApp\Contract\EventWebHook;
use Adideas\ChatApp\Events\EventMessageStatusDelivery;
use Adideas\ChatApp\Events\EventMessageStatusSend;
use Adideas\ChatApp\Events\EventMessageStatusView;
use Adideas\ChatApp\Http\Controllers\WebHookController;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class WebHookControllerTest extends TestCase
{
    public function test__invoke()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'messageStatus.json');
        $request = (new Request())->merge(json_decode($json, true));

        $app = new Application();
        $app->singleton('request', fn() => $request);

        $app->singleton('events', fn($app) => new Dispatcher($app));

        /** @var Dispatcher $dispatcher */
        $dispatcher = $app->make('events');
        $firedEvents = [];

        $fireCallback = function (EventWebHook $event) use (&$firedEvents) {
            $firedEvents[get_class($event)] = $event;
        };

        $dispatcher->listen(EventMessageStatusSend::class, $fireCallback);
        $dispatcher->listen(EventMessageStatusView::class, $fireCallback);
        $dispatcher->listen(EventMessageStatusDelivery::class, $fireCallback);


        $app->call(WebHookController::class);

        self::assertEquals(
            array_keys($firedEvents),
            [
                EventMessageStatusSend::class,
                EventMessageStatusView::class,
                EventMessageStatusDelivery::class
            ]
        );

        self::assertEquals([
            'BAE5DD2EFC88B3C6',
            'BAE50969AD3BEA0F',
            'BAE50969AD3BEA0F',
        ], array_map(fn($i) => $i->getId(), array_values($firedEvents)));
    }
}
