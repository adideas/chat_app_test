<?php

namespace App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic() {
        $model = new Message();
        $model->setBody($text1 = Str::random(100));
        $time1 = time();
        $model->save();

        $model = new Message();
        $model->setBody($text2 = Str::random(50));
        $time2 = time();
        $model->save();

        $model = new Message();
        $model->setBody($text3 = Str::random(200));
        $time3 = time();
        $model->save();

        self::assertEquals([
            $text1, $text2, $text3
        ], Message::pluck('body')->toArray());

        self::assertEquals([
            $time1, $time2, $time3
        ],Message::pluck('created_at')->toArray());

        $model->setBody('TEST UPDATE TEXT');
        $time3 = time();
        $model->save();

        self::assertEquals([
            $time1, $time2, $time3
        ],Message::pluck('updated_at')->toArray());
    }
}
