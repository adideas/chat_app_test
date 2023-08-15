<?php

namespace Adideas\ChatApp\ChatApp\API;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\Models\ChatAppLicense;
use Illuminate\Database\Eloquent\Collection;

class License extends ApiMethod
{
    protected string $_URL = 'https://api.chatapp.online/v1/licenses';
    protected array $_HEADERS = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];

    public function __construct(
        protected string $_token,
        protected int $_cabinetUserId
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
        $list = json_decode($result, true)['data'] ?? [];

        return (new Collection($list))->transform(function (array $item) {
            $model = new ChatAppLicense();
            $model->setAttribute('licenseId', $item['licenseId']);
            $model->setAttribute('licenseTo', $item['licenseTo']);
            $model->setAttribute('cabinetUserId', $this->_cabinetUserId);

            return $model;
        });
    }
}
