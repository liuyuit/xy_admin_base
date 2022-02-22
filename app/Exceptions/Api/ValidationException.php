<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends BaseException
{
    public function __construct(string $message = null, int $code = ErrorCode::VALIDATION, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
