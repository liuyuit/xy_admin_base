<?php


namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Token
 * @package App\Support\Facades
 * @method static array generate($uid, $equipmentId)
 * @method static array refresh($refreshToken, $uid, $equipmentId)
 * @method static bool checkRefreshToken($refreshToken, $uid)
 * @method static void cleanToken($refreshToken)
 * @method static void banToken($uid, $equipmentId)
 * @method static void banTokenByUid($uid)
 * @method static bool checkUid($accessToken, $uid)
 * @method static string|false getUid($accessToken)
 */
class Token extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\User\Token\Token';
    }
}
