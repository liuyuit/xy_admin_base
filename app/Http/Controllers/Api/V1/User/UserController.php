<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\FansType;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\User\User\IndexRequest;
use App\Models\User\User;
use App\Services\User\Subscribe;

class UserController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/user/user",
     *     tags={"Api.User"},
     *     summary="查看作者的个人信息",
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
     *              type="object",
     *              @OA\Property(
     *                  property="code",
     *                  ref="#/components/schemas/code",
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/user",
     *              ),
     *          ),
     *     ),
     * )
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $authorUser = User::findOrFail($request->author_uid);

        // 查看个人主页就设为关注
        $subScribeService = new Subscribe($request->uid, $authorUser->id, FansType::UNPAID);
        $subScribeService->index();
        return apiSuccess($authorUser);
    }
}
