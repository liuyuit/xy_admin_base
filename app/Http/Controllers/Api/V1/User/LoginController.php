<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\User\Login\IndexRequest;
use App\Models\Log\Login;
use App\Models\User\SubUser;
use App\Models\User\User;

class LoginController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/user/login",
     *     tags={"Api.User"},
     *     summary="登录（step 2）",
     *     description="description",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  ref="#/components/schemas/LoginedApiBody",
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="code",
     *                  ref="#/components/schemas/code",
     *              ),
     *              @OA\Property(
     *                  property="msg",
     *                  ref="#/components/schemas/msg",
     *              ),
     *          ),
     *     ),
     * )
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $user = User::findOrFail($request->uid);
        $subUser = SubUser::findOrFail($request->sub_uid);

        $attributes = [
            'uid' => $user->id,
            'sub_uid' => $subUser->id,
            'ip' => $request->getClientIp(),
        ];
        Login::create($attributes);

        return apiSuccess();
    }
}
