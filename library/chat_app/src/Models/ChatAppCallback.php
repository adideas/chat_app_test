<?php

namespace Adideas\ChatApp\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder select(mixed $select)
 * @method static Builder whereId(int $id)
 * @method static ChatAppLicense create(array $attributes = [])
 * @method static ChatAppLicense find(mixed $id, mixed $attributes = [])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static Builder whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static Collection get()
 */
class ChatAppCallback extends Model
{
    protected $table = '__chatapp_callback__';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['licenseId', 'type', 'url'];

    public function newModelQuery(): Builder|ChatAppCallback
    {
        if ($this->getAttribute('licenseId') && $this->getAttribute('type')) {
            return parent::newModelQuery()
                ->where('licenseId', $this->getAttribute('licenseId'))
                ->where('type', $this->getAttribute('type'));
        }

        return parent::newModelQuery();
    }

    public function save(array $options = [])
    {
        $this->exists = $this->newModelQuery()->exists();
        return parent::save($options);
    }
}
