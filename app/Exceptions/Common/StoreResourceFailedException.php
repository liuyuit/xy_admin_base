<?php

namespace App\Exceptions\Common;

class StoreResourceFailedException extends \Dingo\Api\Exception\StoreResourceFailedException
{
    use HasDefaultMessage;

    protected $message = '保存失败';
}
