<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Swagger\IndexRequest;

class SwaggerController extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {

        return apiSuccess(['id' => 1, 'name' => 'Jack']);
    }
}
