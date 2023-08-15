<?php

namespace Adideas\ChatApp\Models;

use Adideas\ChatApp\Jobs\ChatAppRefreshTokenJob;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * @method static Builder select(mixed $select)
 * @method static Builder whereId(int $id)
 * @method static ChatAppToken create(array $attributes = [])
 * @method static ChatAppToken find(mixed $id, mixed $attributes = [])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder whereNull($column)
 * @method static Builder whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static Collection get()
 * @method static ChatAppToken first()
 */
class ChatAppToken extends Model
{
    protected $table = '__chatapp_token__';
    protected $primaryKey = 'cabinetUserId';
    public $timestamps = false;
    protected $fillable = ['cabinetUserId', 'accessToken', 'accessTokenEndTime', 'refreshToken', 'refreshTokenEndTime'];

    protected static function boot()
    {
        parent::boot();
        static::created([ChatAppToken::class, 'eventChange']);
        static::updated([ChatAppToken::class, 'eventChange']);
    }

    public static function eventChange(ChatAppToken $chatApp): void
    {
        $app = App::getInstance();
        /** @var Repository $config */
        $config = $app->get('config');

        if (!$config->get('chat_app.refresh_in_job', false)) {
            return;
        }

        if ($config->get('queue.default', 'sync') != 'sync') {
            $job = new ChatAppRefreshTokenJob($chatApp->getAttribute($chatApp->getKeyName()));
            $job->delay($chatApp->getNextRefresh());

            /** @var Dispatcher $dispatcher */
            $dispatcher = $app->make(Dispatcher::class);
            $dispatcher->dispatch($job);
        }
    }

    protected function getNextRefresh(): Carbon
    {
        return Carbon::createFromTimestamp($this->getAttribute('accessTokenEndTime'));
    }

    public function getRefreshToken(): string
    {
        return $this->getAttribute('refreshToken');
    }

    public function getToken(): string
    {
        return $this->getAttribute('accessToken');
    }
}
