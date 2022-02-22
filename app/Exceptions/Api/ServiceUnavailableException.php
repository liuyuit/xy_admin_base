<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class ServiceUnavailableException extends BaseException
{
    public function __construct(string $message = '外部服务不稳定，请稍后重试', int $code = ErrorCode::SERVICE_UNAVAILABLE, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
