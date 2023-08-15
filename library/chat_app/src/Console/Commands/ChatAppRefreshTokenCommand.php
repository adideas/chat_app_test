<?php

namespace Adideas\ChatApp\Console\Commands;

use Adideas\ChatApp\Models\ChatAppToken;
use Adideas\ChatApp\Scripts\ChatAppScriptInit;
use Illuminate\Console\Command;

class ChatAppRefreshTokenCommand extends Command
{
    protected $signature = 'chatApp:refresh_token';
    protected $description = 'Refresh token chatApp';

    public function handle()
    {
        $time = time() + (60 * 60);

        $cursor = ChatAppToken::where('accessTokenEndTime', '<=', $time)->cursor();

        /** @var ChatAppToken $model */
        foreach ($cursor as $model) {
            $refresh_model = ChatAppScriptInit::refresh($model);

            if (!$refresh_model) {
                $model->delete();
                continue;
            }

            ChatAppScriptInit::updateData($refresh_model);
        }
    }
}
