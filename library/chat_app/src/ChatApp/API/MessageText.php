<?php

namespace Adideas\ChatApp\ChatApp\API;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\Models\ChatAppToken;

class MessageText extends ApiMethod
{
    protected string $_METHOD = 'POST';
    protected string $_URL = 'https://api.chatapp.online/v1/licenses/%s/messengers/grWhatsApp/chats/%s/messages/text';
    protected array $_HEADERS = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];

    public function __construct(
        protected string $_token,
        protected string $_licenseId,
        protected string $_phone,
        protected string $text = 'Hello!'
    )
    {
    }

    public function getURL(): string
    {
        return sprintf($this->_URL, $this->_licenseId, $this->_phone);
    }

    public function getHEADERS(): array
    {
        $headers = parent::getHEADERS();
        $headers['Authorization'] = $this->_token;
        return $headers;
    }

    public function transform(string $result): ?string
    {
        return json_decode($result, true)['data']['id'] ?? null;
    }
}
