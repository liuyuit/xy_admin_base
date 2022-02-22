<?php

namespace App\Exceptions\Common;

class DeleteResourceFailedException extends \Dingo\Api\Exception\DeleteResourceFailedException
{
    use HasDefaultMessage;

    protected $message = '删除失败';
}
