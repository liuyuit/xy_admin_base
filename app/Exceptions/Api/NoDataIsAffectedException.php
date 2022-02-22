<?php

namespace App\Exceptions\Api;

use App\Enums\ErrorCode;
use Symfony\Component\HttpFoundation\Response;

class NoDataIsAffectedException extends BaseException
{
    public function __construct(string $message = '改动数据失败，请重试', int $code = ErrorCode::NO_DATA_IS_AFFECTED, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $statusCode, $headers, $previous);
    }
}
