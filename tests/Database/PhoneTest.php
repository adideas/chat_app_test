<?php

namespace App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic() {
        $model = new Phone();
        $model->setPhone($phone1 = Str::password(7, false, symbols: false));
        $time1 = time();
        $model->save();

        $model = new Phone();
        $model->setPhone($phone2 = Str::password(11, false, symbols: false));
        $time2 = time();
        $model->save();

        $model = new Phone();
        $model->setPhone($phone3 = Str::password(16, false, symbols: false));
        $time3 = time();
        $model->save();

        self::assertEquals([
            $phone1, $phone2, $phone3
        ], Phone::pluck('phone')->toArray());

        self::assertEquals([
            $time1, $time2, $time3
        ],Phone::pluck('created_at')->toArray());

        $model->setPhone('1234567890');
        $time3 = time();
        $model->save();

        self::assertEquals([
            $time1, $time2, $time3
        ],Phone::pluck('updated_at')->toArray());
    }
}
