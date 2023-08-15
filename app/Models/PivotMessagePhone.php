<?php

namespace App\Models;

use App\Application\Pivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method static Builder select(mixed $select)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 */
class PivotMessagePhone extends Pivot
{
    const MESSAGE_UUID = 'message_uuid';
    const PHONE_UUID = 'phone_uuid';

    protected $fillable = [
        self::MESSAGE_UUID,
        self::PHONE_UUID,
        'token_message',
        'status',
        'error_message',
        'reserved_at'
    ];

    private static ?Message $cacheMessageInstance = null;
    private static ?Phone $cachePhoneInstance = null;

    public function getDates(): array
    {
        $dates = parent::getDates();
        $dates[] = 'reserved_at';

        return $dates;
    }

    public function message(): HasOne
    {
        $model = self::$cacheMessageInstance ?: self::$cacheMessageInstance = new Message();
        return $this->hasOne(Message::class, $model->getKeyName(), 'message_uuid');
    }

    public function phone(): HasOne
    {
        $model = self::$cachePhoneInstance ?: self::$cachePhoneInstance = new Phone();
        return $this->hasOne(Phone::class, $model->getKeyName(), 'phone_uuid');
    }

    public static function make(Message $message, Phone $phone): PivotMessagePhone
    {
        $model = new static();
        $model->setAttribute(self::MESSAGE_UUID, $message->getAttribute($message->getKeyName()));
        $model->setAttribute(self::PHONE_UUID, $phone->getAttribute($phone->getKeyName()));
        return $model;
    }
}
