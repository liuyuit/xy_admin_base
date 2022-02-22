<?php

namespace App\Exceptions\Common;

trait HasDefaultMessage
{
    public function __construct($message = null, $errors = null, \Exception $previous = null, $headers = [], $code = 0)
    {
        $message = $message ?? $this->getMessage();
        parent::__construct($message, $errors, $previous, $headers, $code);
    }
}
