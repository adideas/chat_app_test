<?php

namespace Tests\ChatApp\API;

use Adideas\ChatApp\ChatApp\API\GetCallbackUrls;
use Adideas\ChatApp\ChatApp\Client\TestClient;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class GetCallbackUrlsTest extends TestCase
{
    public function test()
    {
        $token = Str::random();
        $api = (new __UT_GetCallbackUrls($token))->run();

        self::assertEquals('https://api.chatapp.online/v1/callbackUrls', $api['url']);
        self::assertEquals('GET', $api['method']);
        self::assertEquals($token, $api['headers']['Authorization']);
        self::assertEquals([], $api['body']);
    }

    public function test_transform()
    {
        $token = Str::random();
        $api = (new __UT_GetCallbackUrls($token));

        $collect = $api->transform(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'GetCallbackUrls.json'));

        self::assertEquals(2, $collect->count());

        self::assertEquals([
            "licenseId" => 37233,
            "type" => "message",
            "url" => "https://webhook.site/f411787a-1def-4ec7-85b0-bba061893d37"
        ], $collect[0]->toArray());

        self::assertEquals([
            "licenseId" => 37233,
            "type" => "messageStatus",
            "url" => "https://webhook.site/f411787a-1def-4ec7-85b0-bba061893d37"
        ], $collect[1]->toArray());
    }
}

class __UT_GetCallbackUrls extends GetCallbackUrls
{
    public function run(): mixed
    {
        static::$_CLIENT = new TestClient();

        return parent::run();
    }
}
