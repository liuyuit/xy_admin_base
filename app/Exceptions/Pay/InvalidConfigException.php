<?php

namespace App\Exceptions\Pay;

class InvalidConfigException extends PayException
{
    protected $message = '配置不合法';
}
