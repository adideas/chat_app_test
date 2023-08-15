<?php

namespace Adideas\ChatApp\ChatApp\Client;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\ChatApp\Contract\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Guzzle implements Client
{
    public function __invoke(ApiMethod $method): mixed
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request($method->getMETHOD(), $method->getURL(), ['headers' => $method->getHEADERS(), 'json' => $method->toArray()]);
            return $method->transform($response->getBody());
        } catch (ClientException $clientException) {
            $response = $clientException->getResponse();
            return $method->transform($response->getBody());
        } catch (GuzzleException $guzzleException) {
            return null;
        }
    }
}
