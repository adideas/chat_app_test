<?php

namespace App\Application;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    const UUID = '0f190897-5863-4d76-8f9f-bbbb4168b095';
    const TIME = 1691859136;
    const TABLE = 'unit_test_check_uuid';

    protected function setUp(): void
    {
        parent::setUp();
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
        });
    }

    public function testSetUUID() {
        $model = new __UTModel();
        $model::creating(fn (__UTModel $m) => self::assertEquals(self::UUID, $m->getAttribute($m->getKeyName())));
        $model::created(fn (__UTModel $m) => self::assertEquals(self::UUID, $m->getAttribute($m->getKeyName())));
        $model->save();

        self::assertEquals(self::UUID, $model->getAttribute($model->getKeyName()));
    }

    public function testSetTimestamp() {
        $model = new __UTModel();
        $model::creating(fn (__UTModel $m) => self::assertNull($model->{$model->getCreatedAtColumn()}));
        $model::created(fn (__UTModel $m) => self::assertEquals(self::TIME, $model->{$model->getCreatedAtColumn()}));
        $model::created(fn (__UTModel $m) => self::assertEquals(self::TIME, $model->{$model->getUpdatedAtColumn()}));
        $model->save();

        self::assertEquals(self::TIME, $model->getAttribute($model->getCreatedAtColumn()));
        self::assertEquals(self::TIME, $model->getAttribute($model->getUpdatedAtColumn()));
    }
}

class __UTModel extends Model {
    protected $table = ModelTest::TABLE;
    protected static function generateUUID(string $key): string
    {
        return ModelTest::UUID;
    }

    public function freshTimestamp(): int
    {
        return ModelTest::TIME;
    }
}
