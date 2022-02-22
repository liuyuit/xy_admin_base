<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class InValidRefreshTokenException extends BaseException
{
    public function __construct(string $message = 'refresh_token 失效，请重新登录', int $code = ErrorCode::INVALID_REFRESH_TOKEN, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
