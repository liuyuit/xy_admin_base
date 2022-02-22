<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Exceptions\Api\ApiException;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\ExceptionHandle\IndexRequest;
use App\Models\User;

class ExceptionHandleController extends BaseController
{
    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
//        throw new ApiException('aa');

//        abort(404);
        $user = User::first('a');
        return apiSuccess();
    }
}
