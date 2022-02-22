<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Exceptions\Api\ApiException;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\User;

class ExceptionController extends BaseController
{

    public function index()
    {
        throw new ApiException('aa');
        User::FindOrFail(123131);
    }
}
