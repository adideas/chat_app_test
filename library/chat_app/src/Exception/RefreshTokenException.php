<?php

namespace Adideas\ChatApp\Exception;

use Exception;
use Illuminate\Database\Eloquent\Model;

class RefreshTokenException extends Exception
{
    public function __construct()
    {
        parent::__construct('Refresh Token Exception');
    }
}
