<?php

namespace Adideas\ChatApp\ChatApp\Client;

use Adideas\ChatApp\ChatApp\Contract\ApiMethod;
use Adideas\ChatApp\ChatApp\Contract\Client;

class Curl implements Client
{
    public function __invoke(ApiMethod $method): mixed
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $method->getURL(),
            CURLOPT_FOLLOWLOCATION => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_CONNECTTIMEOUT  => 10,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_2_0,
            CURLOPT_ACCEPT_ENCODING => 1,
            CURLOPT_HTTPHEADER => $method->getHEADERS()
        ];

        if ($method->getMETHOD() != 'GET') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = http_build_query($method->toArray());

            if ($method->getMETHOD() != 'POST') {
                $options[CURLOPT_CUSTOMREQUEST] = $method->getMETHOD();
            }
        }

        curl_setopt_array($ch, $options);
        if ($result = curl_exec($ch)) {
            curl_close($ch);
            return $method->transform($result);
        }
        curl_close($ch);
        return null;
    }
}
