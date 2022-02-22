<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Models\User\SubUser;
use App\Services\User\Token\Generate;
use Overtrue\Socialite\User;
use App\Http\Requests\Api\V1\Wx\Auth\Callback\IndexRequest;

class AuthorizeController extends BaseController
{
    public function index(IndexRequest $request)
    {
        if ($request->uid) {
            $user = \App\Models\User\User::whereId($request->uid)->first();
            $subUser = SubUser::whereUid($request->uid)->first();
        } else {
            $user = $this->simulateUser();
            $subUser = SubUser::whereOpenid($user->getid())->first();
        }

        if ($subUser === null) { // 新号
            $attributes = [
                'nickname' => $user->getNickname(),
                'avatar' => $user->getAvatar(),
            ];
            $userModel = \App\Models\User\User::create($attributes);

            $attributes = [
                'nickname' => $user->getNickname(),
                'avatar' => $user->getAvatar(),
                'openid' => $user->getId(),
                'uid' => $userModel->id,
            ];
            $subUser = SubUser::create($attributes);
        } else {
            $userModel = $subUser->user;
        }

        $tokenService = new Generate($userModel->id);
        $response = [
            'uid' => $userModel->id,
            'sub_uid' => $subUser->id,
            'access_token' => $tokenService->getAccessToken(),
            'refresh_token' => $tokenService->getRefreshToken(),
            'expires_in' => $tokenService->getExpiresIn(),
            'refresh_token_expires_in' => $tokenService->getRefreshTokenExpiresIn(),
        ];

        return apiSuccess($response);
    }

    public function simulateUser(): User
    {
        $attributes = [
            "id" => "ousEE6GG5Ho-hOOw8eeRDLUgzgtc",
            "name" => "刘宇",
            "nickname" => "刘宇",
            "avatar" => "https://thirdwx.qlogo.cn/mmopen/vi_32/NIAuuyMibmESgNibibyxpsYwHs4ItibMKQAhFyGibaIjnia3VnW8NDx5NXTw1FVweINq0wlCBYZCia0mUVKm71Dp7OQYQ/132",
            "email" => null,
        ];

        return new User($attributes);
    }
}
