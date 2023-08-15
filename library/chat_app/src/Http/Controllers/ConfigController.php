<?php

namespace Adideas\ChatApp\Http\Controllers;

use Adideas\ChatApp\ChatApp\API\UnsetCallbackUrls;
use Adideas\ChatApp\Models\ChatAppCallback;
use Adideas\ChatApp\Models\ChatAppLicense;
use Adideas\ChatApp\Models\ChatAppToken;
use Adideas\ChatApp\Scripts\ChatAppScriptInit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class ConfigController
{
    public function indexToken(): Collection
    {
        return ChatAppToken::select(['cabinetUserId', 'accessTokenEndTime', 'refreshTokenEndTime'])
            ->limit(1)
            ->get();
    }

    public function refreshToken(int $cabinetUserId): Response
    {
        if ($model = ChatAppToken::find($cabinetUserId)) {
            $refresh_model = ChatAppScriptInit::refresh($model);

            if (!$refresh_model) {
                return new Response([], 401);
            }

            ChatAppScriptInit::updateData($refresh_model);
            return new Response([], 200);
        }

        return new Response([], 404);
    }

    public function deleteToken(int $cabinetUserId): Response
    {
        /** @var ChatAppToken $model */
        $model = ChatAppToken::where('cabinetUserId', $cabinetUserId)->first();

        /** @var ChatAppLicense $license */
        foreach (ChatAppLicense::cursor() as $license) {
            (new UnsetCallbackUrls($model->getToken(), $license->getLicenseId()))
                ->run();
        }

        $model->delete();
        return new Response([], 200);
    }

    public function indexLicense(): Collection
    {
        return ChatAppLicense::get();
    }

    public function changeLicense(int $licenseID): Response
    {
        ChatAppLicense::where('licenseId', '<>', $licenseID)
            ->where('isUse', 1)
            ->orWhere('isUse', 0)
            ->update(['isUse' => null]);

        ChatAppLicense::where('licenseId', $licenseID)
            ->update(['isUse' => 1]);

        return new Response([], 200);
    }

    public function indexCallback(): Collection
    {
        return ChatAppCallback::get();
    }
}
