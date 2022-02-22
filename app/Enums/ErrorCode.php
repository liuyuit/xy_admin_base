<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * 有特定意义的错误码
 *
 * @method static static UNAUTHORIZED()
 * @method static static SERVICE_UNAVAILABLE()
 * @method static static NOT_FOUNT()
 * @method static static VALIDATION()
 * @method static static DEFAULT()
 */
final class ErrorCode extends Enum
{
    const UNAUTHORIZED = -1001; // token 授权未通过
    const INVALID_REFRESH_TOKEN = -1002; // refresh_token 失效
    const SERVICE_UNAVAILABLE = -1003; // 外部服务不稳定
    const NOT_FOUNT = -1004; // 资源未找到
    const VALIDATION = -1005; // 表单验证失败
    const NO_DATA_IS_AFFECTED = -1006; // 增删改数据库操作的受影响行数为 0
    const DEFAULT = -2; // 默认，无特殊意义

    public static function getDescription($value): string
    {
        if ($value === static::UNAUTHORIZED) {
            return 'token 授权未通过，请重新登录';
        } elseif ($value === static::INVALID_REFRESH_TOKEN) {
            return 'refresh_token 失效，请重新登录';
        } elseif ($value === static::SERVICE_UNAVAILABLE) {
            return '外部服务不稳定，请重试';
        } elseif ($value === static::NOT_FOUNT) {
            return '资源未找到，请重试';
        } elseif ($value === static::VALIDATION) {
            return '表单验证失败, 请检查输入';
        } elseif ($value === static::NO_DATA_IS_AFFECTED) {
            return '改动数据失败，请重试';
        }

        return parent::getDescription($value);
    }
}
