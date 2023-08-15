<?php

namespace Tests\ChatApp\API;

use Adideas\ChatApp\ChatApp\API\Tokens;
use Adideas\ChatApp\ChatApp\Client\TestClient;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class TokensTest extends TestCase
{
    public function test()
    {
        $password = Str::random();
        $email = Str::random(4) . '@' . Str::random(4) . '.' . Str::random(2);
        $appID = Str::random();

        $api = (new __UT_Token($email, $password, $appID))->run();

        self::assertEquals('https://api.chatapp.online/v1/tokens', $api['url']);
        self::assertEquals('POST', $api['method']);
        self::assertEquals([
            'email' => $email,
            'password' => $password,
            'appId' => $appID
        ], $api['body']);
    }

    public function test_transform()
    {
        $password = Str::random();
        $email = Str::random(4) . '@' . Str::random(4) . '.' . Str::random(2);
        $appID = Str::random();

        $api = (new __UT_Token($email, $password, $appID));
        
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

class __UT_Token extends Tokens {
    public function run(): mixed
    {
        static::$_CLIENT = new TestClient();

        return parent::run();
    }
}
