<?php

namespace Adideas\ChatApp\ChatApp\API;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\Models\ChatAppToken;

class Refresh extends ApiMethod
{
    protected string $_METHOD = 'POST';
    protected string $_URL = 'https://api.chatapp.online/v1/tokens/refresh';
    protected array $_HEADERS = [
        'Content-Type' => 'application/json',
        'Refresh' => ''
    ];

    public function __construct(
        protected string $_refresh,
    )
    {
    }

    public function getHEADERS(): array
    {
        $headers = parent::getHEADERS();
        $headers['Refresh'] = $this->_refresh;
        return $headers;
    }

    public function transform(string $result): ?ChatAppToken
    {
        $data = json_decode($result, true)['data'] ?? null;

        if (!$data) {
            return null;
        }

        $model = new ChatAppToken();
        $model->setAttribute('cabinetUserId', $data['cabinetUserId']);
        $model->setAttribute('accessToken', $data['accessToken']);
        $model->setAttribute('accessTokenEndTime', $data['accessTokenEndTime']);
        $model->setAttribute('refreshToken', $data['refreshToken']);
        $model->setAttribute('refreshTokenEndTime', $data['refreshTokenEndTime']);

        return $model;
    }
}
