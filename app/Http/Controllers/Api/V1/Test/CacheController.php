<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Cache\IndexRequest;
use App\Services\Cache\Test\Test;

class CacheController extends BaseController
{
    public function index(IndexRequest $request)
    {
        $testCache = new Test(2);
        return apiSuccess(['aid' => $testCache->aid]);
    }
}
