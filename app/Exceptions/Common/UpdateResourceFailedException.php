<?php

namespace App\Exceptions\Common;

class UpdateResourceFailedException extends \Dingo\Api\Exception\UpdateResourceFailedException
{
    use HasDefaultMessage;

    protected $message = '更新失败';
}
