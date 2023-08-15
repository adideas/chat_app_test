<?php

namespace App\Models;

use Adideas\ChatApp\Contract\ChatAppMessage;
use App\Application\Model;
use App\Http\Flyway\Message\MessageFlyway;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Builder select(mixed $select)
 * @method static Builder whereId(int $id)
 * @method static Message create(array $attributes = [])
 * @method static Message find(mixed $id, mixed $attributes = [])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static Builder whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 */
class Message extends Model implements ChatAppMessage
{
    use SoftDeletes;
    protected $fillable = ['body'];

    public function phone(): BelongsToMany
    {
        return $this->belongsToMany(Phone::class, PivotMessagePhone::class);
    }

    public function setBody(string $message)
    {
        $this->setAttribute('body', $message);
    }

    public function getBody(): string
    {
        return $this->getAttribute('body');
    }

    public function getIdentify(): string
    {
        return $this->getAttribute($this->getKeyName());
    }

    public static function from(MessageFlyway $dto): static
    {
        $model = new static();
        $model->setBody($dto->getBody());
        return $model;
    }
}
