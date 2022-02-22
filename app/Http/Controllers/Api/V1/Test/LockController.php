<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Lock\IndexRequest;
use App\Support\Facades\Lock;

class LockController extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        Lock::lock(1);
        sleep(4);
        Lock::lock(2);
        sleep(4);
        return apiSuccess();
    }
}
