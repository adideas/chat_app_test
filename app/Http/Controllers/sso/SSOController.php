<?php

namespace App\Http\Controllers\sso;

use Adideas\ChatApp\ChatApp\API\GetCallbackUrls;
use Adideas\ChatApp\ChatApp\API\License;
use Adideas\ChatApp\ChatApp\API\Tokens;
use Adideas\ChatApp\Models\ChatAppCallback;
use Adideas\ChatApp\Models\ChatAppLicense;
use Adideas\ChatApp\Scripts\ChatAppScriptInit;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatApp\ChatAppOauthRequest;
use App\Models\User;
use Illuminate\Http\Response;

class SSOController extends Controller
{
    public function oauthChatApp(ChatAppOauthRequest $request): Response
    {
        $dto = $request->getDTO();

        $modelToken = ChatAppScriptInit::token($dto->getEmail(), $dto->getPassword(), $dto->getAppId());

        if (!$modelToken) {
            return new Response([], 401);
        }

        ChatAppScriptInit::updateData($modelToken);

        return new Response([], 200);
    }
}
