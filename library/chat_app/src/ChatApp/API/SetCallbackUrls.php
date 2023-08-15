<?php

namespace Adideas\ChatApp\ChatApp\API;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;

class SetCallbackUrls extends ApiMethod
{
    protected string $_METHOD = 'PUT';
    protected string $_URL = 'https://api.chatapp.online/v1/licenses/%s/messengers/grWhatsApp/callbackUrl';
    protected array $_HEADERS = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];

    protected array $events = [
        'messageStatus'
    ];

    public function __construct(
        protected string $_token,
        protected int $_licenseId,
        protected string $url,
    )
    {
    }

    public function getHEADERS(): array
    {
        $headers = parent::getHEADERS();
        $headers['Authorization'] = $this->_token;
        return $headers;
    }

    public function getURL(): string
    {
        return sprintf($this->_URL, $this->_licenseId);
    }

    public function transform(string $result): mixed
    {
        return $result;
    }
}
