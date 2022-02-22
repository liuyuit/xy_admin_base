<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends BaseException
{
    public function __construct(string $message = '未找到资源', int $code = ErrorCode::NOT_FOUNT, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
