<?php

namespace App\Services\User;

use ArrayAccess;

class FirstUser implements ArrayAccess
{
    /**
     * @var array
     */
    protected array $attributes;

    protected static self $instance;

    protected function __construct()
    {
        $this->attributes = $this->user();
    }

    public static function make(): self
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function user(): array
    {
        $user = [
            'uid' => 1,
            "openid" => config('system.first_user_openid'),
            "name" => "firstUser",
            "nickname" => "firstUser",
            "avatar" => 'https://via.placeholder.com/132x132.png/000011?text=inventore',
            "email" => null,
        ];

        return $user;
    }

    public static function toArray(): array
    {
        $instance = static::make();
        return $instance->attributes;
    }

    public function setAccessToken($accessToken)
    {
        $this->attributes['access_token'] = $accessToken;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->attributes['refresh_token'] = $refreshToken;
    }

    public function __get($propertyName)
    {
        return $this->attributes[$propertyName] ?? null;
    }

    public function __set($propertyName, $value)
    {
        $this->attributes[$propertyName] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
}
