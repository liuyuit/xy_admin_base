<?php
/**
 *
 * User: Administrator
 * Date: 3/6/2021
 * Time: 3:51 PM
 */

namespace App\Services\User\Token;

class Generate
{
    protected $accessToken;
    protected $refreshToken;
    protected $expiresIn;
    protected $refreshTokenExpiresIn;

    public function __construct($uid)
    {
        $tokenService = new Token();
        $tokens = $tokenService->generate($uid);
        $this->accessToken = $tokens['access_token'];
        $this->refreshToken = $tokens['refresh_token'];
        $this->expiresIn = $tokens['expires_in'];
        $this->refreshTokenExpiresIn = $tokens['refresh_token_expires_in'];
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getRefreshTokenExpiresIn()
    {
        return $this->refreshTokenExpiresIn;
    }
}
