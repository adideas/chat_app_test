<?php

namespace Adideas\ChatApp\ChatApp\Contract;

interface EventWebHook
{
    public function __construct(array $request);
}
