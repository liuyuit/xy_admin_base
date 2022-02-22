<?php

namespace App\Exceptions\Pay;

class InvalidCredentialException extends PayException
{
    protected $message = '支付凭证不合法';
}
