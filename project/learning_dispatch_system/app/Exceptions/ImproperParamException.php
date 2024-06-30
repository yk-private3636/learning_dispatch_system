<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ImproperParamException extends Exception
{
    public function __construct()
    {
        $this->message = __('message.exception.improperParamException');
        $this->code = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    // public function render()
    // {

    // }
}
