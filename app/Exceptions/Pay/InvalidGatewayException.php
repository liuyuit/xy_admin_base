<?php

namespace App\Exceptions\Pay;

class InvalidGatewayException extends PayException
{
    protected $message = '使用了未支持的支付网关';
}
