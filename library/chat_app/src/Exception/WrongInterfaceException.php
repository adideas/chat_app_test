<?php

namespace Adideas\ChatApp\Exception;

use Exception;
use Illuminate\Database\Eloquent\Model;

class WrongInterfaceException extends Exception
{
    public function __construct(Model $model)
    {
        $message = get_class($model) . ' [ not implements ChatAppNotification ]';
        parent::__construct($message);
    }
}
