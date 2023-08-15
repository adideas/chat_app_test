<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PivotMessagePhoneTest extends TestCase
{
    use RefreshDatabase;

    public function testOneMessageManyPhone() {
        $collect = new Collection([]);

        $message = new Message();
        $message->setBody('TEST');
        $message->save();

        $phone = new Phone();
        $phone->setPhone('1234567890');
        $phone->save();

        $pivot = PivotMessagePhone::make($message, $phone);
        self::assertTrue($pivot->save());
        $collect->add($pivot);

        $phone = new Phone();
        $phone->setPhone('0987654321');
        $phone->save();

        $pivot = PivotMessagePhone::make($message, $phone);
        self::assertTrue($pivot->save());
        $collect->add($pivot);

        self::assertEquals(2, $collect->count());

        $collect->each(function (PivotMessagePhone $model) {
            self::assertNotNull($model->message->phone()->where('uuid', $model->phone->uuid));
            self::assertNotNull($model->phone->message()->where('uuid', $model->message->uuid));
        });
    }
}
