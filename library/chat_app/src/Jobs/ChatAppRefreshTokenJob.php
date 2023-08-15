<?php

namespace Adideas\ChatApp\Jobs;

use Adideas\ChatApp\Exception\ModelNotFoundException;
use Adideas\ChatApp\Exception\RefreshTokenException;
use Adideas\ChatApp\Models\ChatAppToken;
use Adideas\ChatApp\Scripts\ChatAppScriptInit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChatAppRefreshTokenJob implements ShouldQueue, ShouldBeUnique
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected int $cabinetUserId, protected ?ChatAppToken $model = null)
    {
    }

    public function uniqueFor(): int
    {
        return 3600;
    }

    public function uniqueId(): string
    {
        return 'ChatAppRefreshTokenJob' . $this->cabinetUserId;
    }

    public function handle(): void
    {
        if ($this->model) {
            $model = $this->model;
        } elseif (!$model = ChatAppToken::find($this->cabinetUserId)) {
            $this->fail(new ModelNotFoundException($this->cabinetUserId));
            return;
        }

        $refresh_model = ChatAppScriptInit::refresh($model);

        if (!$refresh_model) {
            $model->delete();
            $this->fail(new RefreshTokenException());
            return;
        }

        ChatAppScriptInit::updateData($refresh_model);
    }
}
