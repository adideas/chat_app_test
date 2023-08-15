<?php

use Adideas\ChatApp\Http\Controllers\ConfigController;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/** @var Repository $config */
$config = App::getInstance()->get('config');

$prefix_api = $config->get('chat_app.api.prefix', 'chat_app_api');
$middleware = $config->get('chat_app.api.middleware', []);
$middleware = is_array($middleware) ? $middleware : [];

Route::middleware($middleware)->prefix($prefix_api)->group(function () {
    Route::get('token', [ConfigController::class, 'indexToken']);
    Route::post('token/{cabinetUserId}', [ConfigController::class, 'refreshToken']);
    Route::delete('token/{cabinetUserId}', [ConfigController::class, 'deleteToken']);

    Route::get('license', [ConfigController::class, 'indexLicense']);
    Route::post('license/{license}', [ConfigController::class, 'changeLicense']);

    Route::get('callback', [ConfigController::class, 'indexCallback']);
});

unset($config, $prefix_api, $middleware);
