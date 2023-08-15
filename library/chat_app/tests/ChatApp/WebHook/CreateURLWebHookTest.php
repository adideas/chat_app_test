<?php

namespace Tests\ChatApp\WebHook;

use Adideas\ChatApp\ChatApp\WebHook\CreateURLWebHook;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\TestCase;

class CreateURLWebHookTest extends TestCase
{
    public static function dataProvider() {
        return [
            [
                ['app' => ['url' => 'https://local.test.ru'], 'chat_app' => ['web_hook' => ['prefix' => 'chat_app_web_hook']]],
                ['app' => ['url' => 'https://local.test.ru'], 'chat_app' => ['web_hook' => ['prefix' => '/chat_app_web_hook']]],
                ['app' => ['url' => 'https://local.test.ru'], 'chat_app' => ['web_hook' => ['prefix' => 'chat_app_web_hook/']]],
                ['app' => ['url' => 'https://local.test.ru/'], 'chat_app' => ['web_hook' => ['prefix' => 'chat_app_web_hook']]],
                ['app' => ['url' => 'https://local.test.ru/'], 'chat_app' => ['web_hook' => ['prefix' => '/chat_app_web_hook']]],
                ['app' => ['url' => 'https://local.test.ru/'], 'chat_app' => ['web_hook' => ['prefix' => 'chat_app_web_hook/']]],
                ['app' => ['url' => 'https://local.test.ru'], 'chat_app' => ['web_hook' => ['prefix' => 'chat_app_web_hook/']]],
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function test_1(array $env) {
        $app = new Application();
        $app->singleton('config', fn($app) => new Repository($env));

        $url = implode('/', array_slice(explode('/', CreateURLWebHook::create($app)), 0, -1));

        self::assertEquals(
            'https://local.test.ru/chat_app_web_hook',
            $url, json_encode($env)
        );
    }
}
