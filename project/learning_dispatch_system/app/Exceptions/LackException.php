<?php

namespace App\Exceptions;

use Exception;

class LackException extends Exception
{
    public function __construct(
    ){
        $this->message = __('message.exception.lackException');
    }
}
