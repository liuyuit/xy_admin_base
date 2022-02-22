<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Game
 * @package App\Support\Facades
 * @method static void lock($uniq)
 */
class Lock extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Common\Lock';
    }
}
