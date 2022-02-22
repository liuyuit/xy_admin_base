<?php
/**
 *
 * User: Administrator
 * Date: 3/10/2021
 * Time: 9:44 AM
 */

namespace App\Services\Cache;

use Illuminate\Support\Arr;

abstract class CacheBase
{
    /**
     * 全部数据
     * @var array
     */
    protected $all;

    /**
     * 缓存的唯一 id
     * @var string
     */
    protected $uniqid;

    /**
     * 获取全部数据
     * @return array
     */
    abstract protected function allData(): array;

    /**
     * 获取全部数据并缓存
     * @return mixed|string
     */
    public function all()
    {
        $all = remember($this->uniqid, [$this, 'allData']);
        return $all;
    }

    /**
     * 清除数据缓存
     * @return int
     */
    public function clean()
    {
        return forget($this->uniqid);
    }

    public function get($key)
    {
        $all = $this->all();
        if (!isset($all[$key])) {
            return null;
        }

        return $all[$key];
    }

    public function only($keys)
    {
        $all = $this->all();
        $result = Arr::only($all, $keys);
        return $result;
    }

    /**
     * @var mixed|null $property
     * @param $property
     * @return mixed|null
     */
    public function __get($property)
    {
        if (!$this->all) {
            $this->all = $this->all();
        }

        if (!isset($this->all[$property])) {
            return null;
        }

        return $this->all[$property];
    }
}
