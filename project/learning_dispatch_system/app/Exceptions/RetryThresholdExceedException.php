<?php

namespace App\Exceptions;

use Exception;

class RetryThresholdExceedException extends Exception
{
    public function __construct()
    {
        $this->message = __('message.exception.retryThresholdExceed');
    }
}
