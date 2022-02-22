<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\User\Me\IndexRequest;
use App\Http\Requests\Api\V1\User\Me\UpdateRequest;
use App\Models\User\User;

class MeController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/user/me",
     *     tags={"Api.User"},
     *     summary="我的个人信息",
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
     *                  property="msg",
     *                  ref="#/components/schemas/msg",
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/me",
     *              ),
     *          ),
     *     ),
     * )
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $user = User::whereId($request->uid)->firstOrFail()->append(['today_income']);

        return apiSuccess($user);
    }

    /**
     * @OA\Post(
     *     path="/user/me/update",
     *     tags={"Api.User"},
     *     summary="修改我的个人信息",
     *     description="description",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="personal_signature",
     *                      ref="#/components/schemas/personal_signature",
     *                  ),
     *                  allOf={
     *                      @OA\Schema(
     *                          ref="#/components/schemas/LoginedApiBody",
     *                      )
     *                  },
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
     *                  property="msg",
     *                  ref="#/components/schemas/msg",
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/me",
     *              ),
     *          ),
     *     ),
     * )
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $user = User::findOrFail($request->uid);
        $user->personal_signature = $request->personal_signature;
        $user->save();
        return apiSuccess($user);
    }
}
