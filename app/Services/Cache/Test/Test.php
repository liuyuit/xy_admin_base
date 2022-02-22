<?php
/**
 *
 * User: Administrator
 * Date: 3/10/2021
 * Time: 10:12 AM
 */

namespace App\Services\Cache\Test;

use App\Services\Cache\CacheBase;

/**
 * @property int
 * Class Test
 * @package App\Services\Cache\Test
 */
class Test extends CacheBase
{
    protected $gid;
    protected $uniqid;

    public function __construct($gid)
    {
        $this->gid = $gid;
        $this->uniqid = 'game:' . $gid;
    }

    public function allData(): array
    {


        return ['aid' => $this->gid];
    }
}
