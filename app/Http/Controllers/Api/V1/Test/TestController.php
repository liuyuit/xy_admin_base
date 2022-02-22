<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Test\IndexRequest;

class TestController extends BaseController
{
    public function index()
    {
        return apiSuccess();
    }
}
