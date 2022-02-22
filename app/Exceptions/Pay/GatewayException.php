<?php

namespace App\Exceptions\Pay;

class GatewayException extends PayException
{
    protected $message = '网关返回数据异常';
}
