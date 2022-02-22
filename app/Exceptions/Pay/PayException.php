<?php

namespace App\Exceptions\Pay;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PayException extends HttpException
{
    protected $message = '';

    public function __construct(string $message = '', int $code = 0, array $headers = [], \Throwable $previous = null)
    {
        if (!$message && $this->message) {
            $message = $this->message;
        }

        parent::__construct(Response::HTTP_BAD_REQUEST, $message, $previous, $headers, $code);
    }
}
