<?php

namespace App\Exceptions\Pay;

class InvalidProductException extends PayException
{
    protected $message = '商品检验失败';
}
