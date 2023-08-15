<?php

namespace Adideas\ChatApp\Exception;

class ModelNotFoundException extends \Illuminate\Database\Eloquent\ModelNotFoundException
{
    public function __construct(string $modelID = "")
    {
        $message = 'Model not found [' . $modelID . ']';

        parent::__construct($message);
    }
}
