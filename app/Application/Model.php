<?php

namespace App\Application;

use Illuminate\Support\Str;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $dateFormat = 'U';

    protected $casts = [
        'uuid' => 'string',
        self::CREATED_AT => 'integer',
        self::UPDATED_AT => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            if (!$model->getKey()) {
                $model->setAttribute($model->getKeyName(), static::generateUUID($model->getKeyName()));
            }
        });
    }

    public function freshTimestamp(): int
    {
        return time();
    }

    protected static function generateUUID(string $key): string
    {
        return Str::uuid()->toString();
    }
}
