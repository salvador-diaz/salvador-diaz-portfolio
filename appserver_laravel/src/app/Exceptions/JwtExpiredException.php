<?php

namespace App\Exceptions;

use Exception;

class JwtExpiredException extends Exception
{
    public function __construct($message = "Token has expired", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
