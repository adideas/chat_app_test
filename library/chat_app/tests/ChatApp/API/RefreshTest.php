<?php

namespace Tests\ChatApp\API;

use Adideas\ChatApp\ChatApp\API\Refresh;
use Adideas\ChatApp\ChatApp\Client\TestClient;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class RefreshTest extends TestCase
{
    public function test()
    {
        $token = Str::random();
        $api = (new __UT_Refresh($token))->run();

        self::assertEquals('https://api.chatapp.online/v1/tokens/refresh', $api['url']);
        self::assertEquals('POST', $api['method']);
        self::assertEquals($token, $api['headers']['Refresh']);
        self::assertEquals([], $api['body']);
    }

    public function test_transform()
    {
        $token = Str::random();
        $api = (new __UT_Refresh($token));

        $model = $api->transform(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Refresh.json'));

        self::assertEquals([
            "cabinetUserId" => 14545,
            "accessToken" => '$2y$10$E47dCl4tDArpVtbii5Al3OPJd3zy6Ey16ZzfhvlqFZFIhhEl1F8Ui',
            "accessTokenEndTime" => 1625915202,
            "refreshToken" => '$2y$10$s7dE./HS7/Dc27U8HIzXvO6ksWjDISokpRukOC2aZfXJT9t9YyQPC',
            "refreshTokenEndTime" => 1626001602
        ], $model->toArray());
    }
}

class __UT_Refresh extends Refresh
{
    public function run(): mixed
    {
        static::$_CLIENT = new TestClient();

        return parent::run();
    }
}
