<?php

namespace App\Exceptions\Pay;

class InvalidArgumentException extends PayException
{
    protected $message = '参数不合法';
}
