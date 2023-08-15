<?php

namespace Tests\ChatApp\API;

use Adideas\ChatApp\ChatApp\API\License;
use Adideas\ChatApp\ChatApp\Client\TestClient;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class LicenseTest extends TestCase
{
    public function test()
    {
        $token = Str::random();
        $cabinetID = rand(1, 1000);
        $api = (new __UT_License($token, $cabinetID))->run();

        self::assertEquals('https://api.chatapp.online/v1/licenses', $api['url']);
        self::assertEquals('GET', $api['method']);
        self::assertEquals($token, $api['headers']['Authorization']);
        self::assertEquals([], $api['body']);
    }

    public function test_transform()
    {
        $token = Str::random();
        $cabinetID = rand(1, 1000);
        $api = (new __UT_License($token, $cabinetID));

        $collect = $api->transform(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'License.json'));

        self::assertEquals(2, $collect->count());

        self::assertEquals([
            "licenseId" => 37233,
            "licenseTo" => 1692122395,
            "cabinetUserId" => $cabinetID
        ], $collect[0]->toArray());

        self::assertEquals([
            "licenseId" => 37236,
            "licenseTo" => 1692122399,
            "cabinetUserId" => $cabinetID
        ], $collect[1]->toArray());
    }
}

class __UT_License extends License
{
    public function run(): mixed
    {
        static::$_CLIENT = new TestClient();

        return parent::run();
    }
}
