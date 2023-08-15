<?php

namespace Tests\ChatApp\API;

use Adideas\ChatApp\ChatApp\API\License;
use Adideas\ChatApp\ChatApp\API\MessageText;
use Adideas\ChatApp\ChatApp\Client\TestClient;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class MessageTextTest extends TestCase
{
    public function test()
    {
        $token = Str::random();
        $text = Str::random();
        $license = rand(1, 1000);
        $phone = Str::password(11, letters: false, symbols: false);
        $api = (new __UT_MessageText($token, $license, $phone, $text))->run();

        self::assertEquals(
            "https://api.chatapp.online/v1/licenses/$license/messengers/grWhatsApp/chats/$phone/messages/text",
            $api['url']
        );
        self::assertEquals('POST', $api['method']);
        self::assertEquals($token, $api['headers']['Authorization']);
        self::assertEquals(['text' => $text], $api['body']);
    }

    public function test_transform()
    {
        $token = Str::random();
        $text = Str::random();
        $license = rand(1, 1000);
        $phone = Str::password(11, letters: false, symbols: false);
        $api = (new __UT_MessageText($token, $license, $phone, $text));

        $trackID = $api->transform(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'MessageText.json'));

        self::assertEquals('BAE50969AD3BEA0F', $trackID);
    }
}

class __UT_MessageText extends MessageText {
    public function run(): mixed
    {
        static::$_CLIENT = new TestClient();

        return parent::run();
    }
}

