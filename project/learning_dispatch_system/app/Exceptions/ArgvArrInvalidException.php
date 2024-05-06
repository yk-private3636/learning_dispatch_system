<?php

namespace App\Exceptions;

use Exception;

class ArgvArrInvalidException extends Exception
{
    public function __construct()
    {
        $this->messages = __('message.exception.argvArrInvalidException');
    }
}
