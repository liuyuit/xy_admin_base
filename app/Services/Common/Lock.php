<?php

namespace App\Services\Common;

use Illuminate\Support\Facades\Redis;

/**
 * 分布式独占锁
 * Class Lock
 * @package App\Services\Common
 */
class Lock
{
    protected $redisPrefix = 'lock:';
    protected $redisKey;
    protected $ttl = 4; // 一个进程最多独占资源 4 秒，超时则自动释放锁

    public function lock($uniq)
    {
        $this->iniRedisKey($uniq);

        $num = 0;

        do {
            if (++$num >= 20) {
                throw new \Exception('获取独占锁失败');
            }

            $gotLock = Redis::setnx($this->redisKey, 1);
            if ($gotLock) {
                Redis::expire($this->redisKey, $this->ttl);
                return;
            }
            usleep(200000); // 休眠 200 毫秒后再次尝试获取独占锁
        } while (true);
    }

    public function unlock()
    {
        Redis::del($this->redisKey);
    }

    public function __destruct()
    {
        $this->unlock();
    }

    protected function iniRedisKey($uniq)
    {
        $this->redisKey = $this->redisPrefix . $uniq;
    }
}
