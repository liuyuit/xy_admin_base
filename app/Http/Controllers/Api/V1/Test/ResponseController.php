<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Response\IndexRequest;
use App\Models\User;

class ResponseController extends BaseController
{
    public function index()
    {
        return apiSuccess();

        /*$users = User::all();
        return apiSuccess($users);
        {
            "code": 0,
            "msg": "成功",
            "data": [
                {
                    "id": 1,
                    "name": "admin",
                    "email": "admin@qq.com",
                    "email_verified_at": null,
                    "created_at": null,
                    "updated_at": null
                }
            ]
        }*/
    }
}
