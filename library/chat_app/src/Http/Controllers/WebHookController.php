<?php

namespace Adideas\ChatApp\Http\Controllers;

use Adideas\ChatApp\ChatApp\Contract\EventWebHook;
use Adideas\ChatApp\ChatApp\WebHook\LoaderWebHook;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class WebHookController
{
    public function __invoke(Request $request): void
    {
        try {
            /** @var Dispatcher $dispatcher */
            $dispatcher = Application::getInstance()->make(Dispatcher::class);

            $loader = new LoaderWebHook($request->all());
            $loader->getEvents()->each(function (EventWebHook $event) use ($dispatcher) {
                $dispatcher->dispatch($event);
            });
        } catch (\Exception $exception) {
            // to logger
        }
    }
}
