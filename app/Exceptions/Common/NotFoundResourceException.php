<?php

namespace App\Exceptions\Common;

use App\Exceptions\Common\HasDefaultMessage;

class NotFoundResourceException extends \Dingo\Api\Exception\ResourceException
{
    use HasDefaultMessage;

    protected $message = '未找到数据';

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json(['message' => $this->getMessage()]);
    }
}
