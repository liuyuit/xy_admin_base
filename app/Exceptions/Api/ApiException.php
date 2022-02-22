<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class ApiException extends BaseException
{
    public function __construct(string $message = '系统异常，请稍后重试', int $code = ErrorCode::DEFAULT, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
