<?php

namespace Adideas\ChatApp\Scripts;

use Adideas\ChatApp\ChatApp\API\GetCallbackUrls;
use Adideas\ChatApp\ChatApp\API\License;
use Adideas\ChatApp\ChatApp\API\Refresh;
use Adideas\ChatApp\ChatApp\API\SetCallbackUrls;
use Adideas\ChatApp\ChatApp\API\Tokens;
use Adideas\ChatApp\ChatApp\WebHook\CreateURLWebHook;
use Adideas\ChatApp\Exception\RefreshTokenException;
use Adideas\ChatApp\Models\ChatAppCallback;
use Adideas\ChatApp\Models\ChatAppLicense;
use Adideas\ChatApp\Models\ChatAppToken;
use Illuminate\Http\Response;

class ChatAppScriptInit
{
    public static function token(string $email, string $password, string $appId): ?ChatAppToken
    {
        $tokens = new Tokens($email, $password, $appId);
        if (!$modelToken = $tokens->run()) {
            return null;
        }
        $modelToken->save();
        return $modelToken;
    }

    public static function refresh(ChatAppToken $model): ?ChatAppToken
    {
        $refresh = new Refresh($model->getRefreshToken());
        if (!$modelToken = $refresh->run()) {
            return null;
        }
        $modelToken->save();
        return $modelToken;
    }

    public static function updateData(ChatAppToken $model): void
    {
        $license = new License($model->accessToken, $model->cabinetUserId);

        $license_model = $license->run();

        if ($license_model->count()) {
            $license_model->each(function (ChatAppLicense $license) {
                $license->save();
            });
        }

        if (ChatAppLicense::where('isUse', 1)->count() < 1) {
            $licenseID = ChatAppLicense::first()->licenseId ?? 0;
            ChatAppLicense::where('licenseId', $licenseID)
                ->update(['isUse' => 1]);
        }

        if (!self::getCallbacks($model)) {
            self::registerAllCallback($model);
            self::getCallbacks($model);
        }
    }

    private static function registerAllCallback(ChatAppToken $model): void
    {
        $cursor = ChatAppLicense::cursor();

        /** @var ChatAppLicense $license */
        foreach ($cursor as $license) {
            $url = CreateURLWebHook::create();

            dump((new SetCallbackUrls(
                $model->getToken(),
                $license->licenseId,
                $url
            ))->run(), $url);
        }
    }

    private static function getCallbacks(ChatAppToken $model): bool {
        $callback = new GetCallbackUrls($model->accessToken);
        $modelCallback = $callback->run();
        if ($modelCallback->count()) {
            $modelCallback->each(function (ChatAppCallback $callback) {
                $callback->save();
            });
            return true;
        }
        return false;
    }
}
