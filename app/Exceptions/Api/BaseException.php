<?php
/**
 *
 * User: Administrator
 * Date: 3/3/2021
 * Time: 10:58 AM
 */

namespace App\Exceptions\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class BaseException extends HttpException
{
    public function __construct(string $message = null, int $code = 0, int $statusCode = Response::HTTP_OK, array $headers = [], \Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
