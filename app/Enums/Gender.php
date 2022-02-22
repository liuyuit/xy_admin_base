<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * 性别
 *
 * @method static static UNKNOWN()
 * @method static static MALE()
 * @method static static FEMALE()
 */
final class Gender extends Enum
{
    public const UNKNOWN = 0;
    public const MALE = 1;
    public const FEMALE = 2;

    public static function getDescription($value): string
    {
        if ($value === self::MALE) {
            return '男';
        } elseif ($value === self::FEMALE) {
            return '女';
        } elseif ($value === self::UNKNOWN) {
            return '未知';
        }

        return parent::getDescription($value);
    }
}
