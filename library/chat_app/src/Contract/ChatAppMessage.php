<?php

namespace Adideas\ChatApp\Contract;

interface ChatAppMessage
{
    public function getBody(): string;
    public function getIdentify(): string;
}
