<?php

namespace Adideas\ChatApp\ChatApp\Contract;

use Exception;

interface Client
{
    public function __invoke(ApiMethod $method): mixed;
}
