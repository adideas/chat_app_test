<?php

namespace App\Models;

use Adideas\ChatApp\Contract\ChatAppPhone;
use App\Application\Model;
use App\Http\Flyway\Phone\PhoneFlyway;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method static Builder select(mixed $select)
 * @method static Builder whereId(int $id)
 * @method static Phone create(array $attributes = [])
 * @method static Phone find(mixed $id, mixed $attributes = [])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static Builder whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 */
class Phone extends Model implements ChatAppPhone
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['phone'];

    public static function from(PhoneFlyway $dto): static
    {
        $model = new static();
        $model->setPhone($dto->getPhone());

        return $model;
    }

    public function message(): BelongsToMany
    {
        return $this->belongsToMany(Message::class, PivotMessagePhone::class);
    }

    public function setPhone(string $phone): void
    {
        $this->setAttribute('phone', $phone);
    }

    public function getPhone(): string
    {
        return $this->getAttribute('phone');
    }

    public function getIdentify(): string
    {
        return $this->getAttribute($this->getKeyName());
    }
}
