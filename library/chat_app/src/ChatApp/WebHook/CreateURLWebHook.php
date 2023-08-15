<?php

namespace Adideas\ChatApp\ChatApp\WebHook;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

class CreateURLWebHook
{
    public static function create(?Application $application = null) {
        $app = $application ?: Application::getInstance();

        /** @var Repository $config */
        $config = $app->get('config');

        $basicPath = $config->get('app.url', null);
        $prefix = $config->get('chat_app.web_hook.prefix', 'chat_app_web_hook');
        $key = Str::password(symbols: false);

        [$http, $basicPath] = explode('//', $basicPath);

        return $http . '//' . str_replace('//', '/', $basicPath . '/' . $prefix . '/' . $key);
    }
}
