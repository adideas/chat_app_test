<?php

namespace App\Application;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PivotTest extends TestCase
{
    use RefreshDatabase;

    const TABLE = 'unit_test_check_pivot';

    protected function setUp(): void
    {
        parent::setUp();
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->uuid()->primary();
        });
    }

    public function testSetTimestamp() {
        $model = new __UTPivot();
        $model::creating(fn (__UTPivot $m) => self::assertNull($model->{$model->getCreatedAtColumn()}));
        $model::created(fn (__UTPivot $m) => self::assertNull($model->{$model->getCreatedAtColumn()}));
        $model::created(fn (__UTPivot $m) => self::assertNull($model->{$model->getUpdatedAtColumn()}));
        $model->save();

        self::assertNull($model->getAttribute($model->getCreatedAtColumn()));
        self::assertNull($model->getAttribute($model->getUpdatedAtColumn()));
    }
}

class __UTPivot extends Pivot {
    protected $table = PivotTest::TABLE;
}
