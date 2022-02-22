<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends BaseException
{
    public function __construct(string $message = '授权未通过，请重新登录', int $code = ErrorCode::UNAUTHORIZED, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
