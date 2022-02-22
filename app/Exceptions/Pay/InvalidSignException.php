<?php

namespace App\Exceptions\Pay;

class InvalidSignException extends PayException
{
    protected $message = '验证签名失败';
}
