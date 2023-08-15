<?php

namespace Adideas\ChatApp\ChatApp\API;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\Models\ChatAppCallback;
use Adideas\ChatApp\Models\ChatAppLicense;
use Illuminate\Database\Eloquent\Collection;

class GetCallbackUrls extends ApiMethod
{
    protected string $_URL = 'https://api.chatapp.online/v1/callbackUrls';
    protected array $_HEADERS = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];

    public function __construct(
        protected string $_token
    )
    {
    }

    public function getHEADERS(): array
    {
        $headers = parent::getHEADERS();
        $headers['Authorization'] = $this->_token;
        return $headers;
    }

    public function transform(string $result): Collection
    {
        $licenseCallbacks = json_decode($result, true)['data'] ?? [];

        $callbacks = new Collection([]);

        foreach($licenseCallbacks as $callback) {
            foreach ($callback['events'] as $event) {
                $model = new ChatAppCallback();
                $model->setAttribute('licenseId', $callback['licenseId']);
                $model->setAttribute('type', $event);
                $model->setAttribute('url', $callback['url']);

                $callbacks->add($model);
            }
        }

        return $callbacks;
    }
}
