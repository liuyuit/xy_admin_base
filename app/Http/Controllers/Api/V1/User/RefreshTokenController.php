<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\User\RefreshToken\IndexRequest;
use App\Services\User\Token\Refresh;

class RefreshTokenController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/user/refresh-token",
     *     tags={"Api.User"},
     *     summary="刷新 token（step 3）",
     *     description="当 access_token 过期但 refresh_token 仍在有效期内时，需要请求此接口刷新 token 。如果 refresh_token 也已过期，此接口将响应 code 为 -1002。此时需要用户重新授权",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="uid",
     *                      ref="#/components/schemas/uid",
     *                  ),
     *                  @OA\Property(
     *                      property="sub_uid",
     *                      ref="#/components/schemas/sub_uid",
     *                  ),
     *                  @OA\Property(
     *                      property="refresh_token",
     *                      ref="#/components/schemas/refresh_token",
     *                  ),
     *              ),
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
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/token_body",
     *              ),
     *          ),
     *     ),
     * )
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $tokenService = new Refresh($request->refresh_token, $request->uid);

        $response = [
            'access_token' => $tokenService->getAccessToken(),
            'refresh_token' => $tokenService->getRefreshToken(),
            'expires_in' => $tokenService->getExpiresIn(),
            'refresh_token_expires_in' => $tokenService->getRefreshTokenExpiresIn(),
        ];
        return apiSuccess($response);
    }
}
