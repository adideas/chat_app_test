<?php

use Adideas\ChatApp\Http\Controllers\WebHookController;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/** @var Repository $config */
$config = App::getInstance()->get('config');

$prefix_web_hook = $config->get('chat_app.web_hook.prefix', 'chat_app_web_hook');
$middleware = $config->get('chat_app.web_hook.middleware', []);
$middleware = is_array($middleware) ? $middleware : [];


Route::middleware($middleware)->prefix($prefix_web_hook)->group(function () {
    Route::any( '/{default?}', [WebHookController::class, '__invoke']);
});

unset($config, $prefix_web_hook, $middleware);
