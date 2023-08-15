<?php

namespace Adideas\ChatApp\ChatApp\Client;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\ChatApp\Contract\Client;

class TestClient implements Client
{
    public function __invoke(ApiMethod $method): mixed
    {
        return [
            'url' => $method->getURL(),
            'method' => $method->getMETHOD(),
            'headers' => $method->getHEADERS(),
            'body' => $method->toArray()
        ];
    }
}
