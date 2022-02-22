<?php
/**
 *
 * User: Administrator
 * Date: 3/6/2021
 * Time: 2:44 PM
 */

namespace App\Services\User\Token;

use App\Exceptions\Api\InValidRefreshTokenException;
use App\Models\User\User;
use Illuminate\Support\Facades\Redis;

class Token
{
    protected $accessTokenPrefix = 'access_token:'; // access_token 的 redis key 前缀
    protected $refreshTokenPrefix = 'refresh_token:'; // refresh_token 的 redis key 前缀 的 redis key 前缀
    protected $tokenRecordPrefix = 'record_token:'; // 用于记录 access_token 和 refresh_token 的 redis key 前缀 的 redis key 前缀
    protected $accessTokenTtl = 86400; // access_token 过期时间（一天）
    protected $refreshTokenTtl = 2592000; // refresh_token 过期时间（1 个月）
    protected $tokenRecordTtl = 2592000; // record_token 过期时间（1 个月），该值不能小于 $refreshTokenTtl，否则可能导致封禁用户设备登录时不能 清除 access_token 和 refresh_token

    /**
     * 生成 token
     * @param $uid
     * @return array
     */
    public function generate($uid): array
    {
        $this->banToken($uid); // 生成新 token 之前先清除旧的 token。
        $accessToken = uniqid($uid);
        $refreshToken = uniqid($uid);
        $accessTokenKey = $this->getAccessTokenKey($accessToken);
        $refreshTokenKey = $this->getRefreshTokenKey($refreshToken);
        $tokenRecordKey = $this->gettokenRecordKey($uid);

        $dictionary = [
            'uid' => $uid,
        ];
        Redis::hmset($accessTokenKey, $dictionary);
        Redis::expire($accessTokenKey, $this->accessTokenTtl);

        $dictionary = [
            'uid' => $uid,
            'access_token' => $accessToken,
        ];
        Redis::hmset($refreshTokenKey, $dictionary);
        Redis::expire($refreshTokenKey, $this->refreshTokenTtl);

        $dictionary = [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
        Redis::hmset($tokenRecordKey, $dictionary);
        Redis::expire($tokenRecordKey, $this->tokenRecordTtl);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => $this->accessTokenTtl,
            'refresh_token_expires_in' => $this->refreshTokenTtl,
        ];
    }

    /**
     * 刷新 token
     * @param $refreshToken
     * @param $uid
     * @param $equipmentId
     * @return array
     */
    public function refresh($refreshToken, $uid): array
    {
        if (!$this->checkRefreshToken($refreshToken, $uid)) {
            throw new InValidRefreshTokenException();
        }
        $this->cleanToken($refreshToken);
        return $this->generate($uid);
    }

    public function checkRefreshToken($refreshToken, $uid): bool
    {
        $refreshTokenValues = $this->getRefreshTokenValues($refreshToken);
        if (empty($refreshTokenValues)) {
            return false;
        }

        return $refreshTokenValues['uid'] == $uid;
    }

    public function checkUid($accessToken, $uid): bool
    {
        $uidOnRedis = $this->getUid($accessToken);
        if (empty($uidOnRedis)) {
            return false;
        }

        return $uidOnRedis == $uid;
    }

    /**
     * @param $accessToken
     * @return User|User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getUser($accessToken): User
    {
        $uid = $this->getUid($accessToken);
        return User::findOrFail($uid);
    }

    /**
     * @param $accessToken
     * @return string|false
     */
    public function getUid($accessToken)
    {
        $accessTokenKey = $this->getAccessTokenKey($accessToken);
        return Redis::hget($accessTokenKey, 'uid');
    }

    /**
     * 清除旧的 token
     * @param $refreshToken
     */
    protected function cleanToken($refreshToken)
    {
        $refreshTokenValues = $this->getRefreshTokenValues($refreshToken);
        $accessTokenKey = $this->getAccessTokenKey($refreshTokenValues['access_token']);
        $refreshTokenKey = $this->getRefreshTokenKey($refreshToken);

        Redis::del($accessTokenKey);
        Redis::del($refreshTokenKey);
    }

    /**
     * 禁止某个用户的 token 登录
     * @param $uid
     */
    public function banToken($uid)
    {
        $tokenRecordValues = $this->getTokenRecordValues($uid);
        if (!$tokenRecordValues) {
            return;
        }
        $accessTokenKey = $this->getAccessTokenKey($tokenRecordValues['access_token']);
        $refreshTokenKey = $this->getRefreshTokenKey($tokenRecordValues['refresh_token']);
        $tokenRecordKey = $this->getTokenRecordKey($uid);

        Redis::del($accessTokenKey);
        Redis::del($refreshTokenKey);
        Redis::del($tokenRecordKey);
    }

    protected function getRefreshTokenValues($refreshToken)
    {
        $refreshTokenKey = $this->getRefreshTokenKey($refreshToken);
        return Redis::hgetAll($refreshTokenKey);
    }

    protected function getAccessTokenValues($accessToken)
    {
        $accessTokenKey = $this->getAccessTokenKey($accessToken);
        return Redis::hgetAll($accessTokenKey);
    }

    protected function getTokenRecordValues($uid)
    {
        $tokenRecordKey = $this->getTokenRecordKey($uid);
        return Redis::hgetAll($tokenRecordKey);
    }

    protected function getAccessTokenKey($accessToken)
    {
        return $this->accessTokenPrefix . $accessToken;
    }

    protected function getRefreshTokenKey($refreshToken)
    {
        return $this->refreshTokenPrefix . $refreshToken;
    }

    protected function getTokenRecordKey($uid)
    {
        return "{$this->tokenRecordPrefix}{$uid}";
    }
}
