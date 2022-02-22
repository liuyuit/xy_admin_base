<?php

use App\Enums\PlatformType;
use App\Models\Config\GamePlatform;
use App\Models\System\Admin;
use App\Models\User\User;
use Brokenice\LaravelMysqlPartition\Models\Partition;
use Carbon\Carbon;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Redis;

if (!function_exists('used')) {
    /**
     * 用以解决unused提示
     *
     * @param mixed ...$params
     */
    function used(...$params): void
    {
        // do nothing
    }
}

if (!function_exists('admin')) {
    /**
     * 返回当前登录的后台用户
     */
    function admin()
    {
        return app('request')->admin();
    }
}

if (!function_exists('user')) {
    /**
     * 返回当前登录的后台用户
     */
    function user()
    {
        return app('request')->user();
    }
}

if (!function_exists('adminId')) {
    /**
     * 返回当前登录的后台用户ID
     */
    function adminId(): int
    {
        return admin()->id;
    }
}

if (!function_exists('geneRandomString')) {
    /**
     * 生成随机字符串
     *
     * @param int $length
     * @return false|string
     */
    function geneRandomString($length = 10): string
    {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $multiplier = ceil($length / strlen($input));
        $string = str_repeat($input, $multiplier);
        $string = str_shuffle($string);
        return substr($string, 1, $length);
    }
}

if (!function_exists('getSortTreeByRecursive')) {
    /**
     * 通过递归获取无限极树级结构 同时按节点的order字段升序排序
     *
     * @param array $array
     * @param int $pid
     * @param int $level
     * @return array
     */
    function getSortTreeByRecursive(array $array, $pid = 0, $level = 0): array
    {
        $tree = [];
        foreach ($array as $key => $value) {
            if ($value['pid'] == $pid) {
                $value['level'] = $level;
                if ($children = getSortTreeByRecursive($array, $value['id'], $level + 1)) {
                    $orders = array_column($children, 'order');
                    array_multisort($orders, SORT_ASC, SORT_NUMERIC, $children);
                    $value['children'] = $children;
                }
                $tree[] = $value;
            }
        }
        $orders = array_column($tree, 'order');
        array_multisort($orders, SORT_ASC, SORT_NUMERIC, $tree);
        return $tree;
    }
}

if (!function_exists('inDocker')) {
    /**
     * 判断项目是否在Docker环境中运行
     *
     * @return bool
     */
    function inDocker(): bool
    {
        return \Cache::remember('in-docker', now()->addSeconds(30), function () {
            $output = null;
            $return = null;
            exec('ls -alh /.dockerenv 2>&1', $output, $return);
            return !$return;
        });
    }
}

if (!function_exists('geneUUID')) {
    /**
     * 生成32位的UUID. 采用RFC-4122 Version 6草稿中的按时间排序的UUID，去掉了短横线
     *
     * @link https://uuid.ramsey.dev/en/4.0.1/nonstandard/version6.html
     * @link https://tools.ietf.org/html/rfc4122
     * @return string
     */
    function geneUUID(): string
    {
        // 如果没有启动参数，Docker会给项目PHP容器的分配同一个MAC地址，而此组件默认使用MAC地址，最终导致节点一致，所以这里使用随机节点
        $nodeProvider = new RandomNodeProvider();
        $uuidString = Uuid::uuid6($nodeProvider->getNode())->toString();
        // 去掉无意义的短横线
        $uuidString = str_replace('-', '', $uuidString);
        return $uuidString;
    }
}

if (!function_exists('geneOrderNo')) {
    /**
     * 生成订单号
     *
     * @return string
     */
    function geneOrderNo(): string
    {
        $array = gettimeofday();
        $orderNo = date('YmdHis') . $array['usec'];
        return $orderNo;
    }
}

if (!function_exists('geneMonthlyPartitions')) {
    /**
     * 生成按月分区的配置
     *
     * @param int $nums
     * @return Partition[]
     */
    function geneMonthlyPartitions($nums = 12): array
    {
        $partitions = [];
        $belongTo = Carbon::now()->startOfMonth();
        $threshold = (clone $belongTo)->addMonth();

        for ($i = 0; $i < $nums; $i++) {
            $partitions[] = new Partition(
                "p{$belongTo->format('Ym')}",
                Partition::RANGE_TYPE,
                $threshold->timestamp
            );
            $belongTo->addMonth();
            $threshold->addMonth();
        }

        return $partitions;
    }
}

if (!function_exists('addPhoneAreaCode')) {
    /**
     * 手机加上国内区号
     *
     * @param $phone
     * @return string
     */
    function addPhoneAreaCode($phone): string
    {
        return strpos($phone, '+') === false ? "+86{$phone}" : $phone;
    }
}

if (!function_exists('getMicroTime')) {
    /**
     * 获取格林威治秒数（精确到微妙）
     *
     * @return float
     */
    function getMicroTime(): float
    {
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
}

if (!function_exists('remember')) {
    /**
     * 缓存数据
     *
     * @param $uniqid
     * @param $dataSource mixed|\Closure 数据来源
     * @param int $ttl
     * @return mixed|string
     */
    function remember($uniqid, $dataSource, $ttl = 600)
    {
        $redisKey = 'remember:' . $uniqid;
        $result = Redis::get($redisKey);

        if ($result) {
            return unserialize($result);
        }

        if ($dataSource instanceof \Closure) {
            $result = $dataSource();
        } elseif (is_array($dataSource) && isset($dataSource[0]) && is_object($dataSource[0])) {
            $object = $dataSource[0];
            $function = $dataSource[1];
            $args = isset($dataSource[2]) ? $dataSource[2] : [];
            $result = call_user_func_array([$object, $function], $args);
        } else {
            $result = $dataSource;
        }

        Redis::setex($redisKey, $ttl, serialize($result));
        return $result;
    }
}

if (!function_exists('forget')) {
    /**
     * 清除已缓存的数据
     *
     * @param $uniqid
     * @return int
     */
    function forget($uniqid)
    {
        $redisKey = 'remember:' . $uniqid;
        return Redis::del($redisKey);
    }
}

if (!function_exists('isPhone')) {
    /**
     * 判断是否为手机号码
     *
     * @param $str
     * @return false|int
     */
    function isPhone($str)
    {
        return preg_match('/^1[3456789]\d{9}$/', $str);
    }
}

if (!function_exists('coverPhone')) {
    /**
     * 设置手机掩码
     *
     * @param $phone
     * @return string
     */
    function coverPhone($phone)
    {
        if (isPhone($phone)) {
            $phone = substr_replace($phone, '****', 3, 4);
        } elseif (empty($phone)) {
            $phone = '';
        }

        return $phone;
    }
}

if (!function_exists('coverPhoneForAdmin')) {
    /**
     * 设置手机掩码
     *
     * @param $phone
     * @return string
     */
    function coverPhoneForAdmin($phone)
    {
        if (isPhone($phone)) {
            $phone = substr_replace($phone, '****', 3, 4);
        }

        return $phone;
    }
}

if (!function_exists('where')) {
    /**
     * 当前进程在哪个模块中
     *
     * @return string
     */
    function where(): string
    {
        if (php_sapi_name() === 'cli') {
            $in = 'cli';
        } else {
            /** @var Request $request */
            $request = app('request');
            $url = $request->url();
            if (Str::contains($url, config('app.admin_url'))) {
                $in = 'admin';
            } elseif (Str::contains($url, config('app.api_url'))) {
                $in = 'api';
            } elseif (Str::contains($url, config('app.pay_url'))) {
                $in = 'pay';
            } else {
                $in = 'cgi';
            }
        }

        return $in;
    }
}

if (!function_exists('in')) {
    /**
     * 当前进程是否在指定模块中
     *
     * @param string $where
     * @return string
     */
    function in($where): string
    {
        return where() === $where;
    }
}

if (!function_exists('unzip')) {
    /**
     * 解压zip文件
     *
     * @param string $from 要解压的文件
     * @param string $to 解压到哪里
     * @return mixed
     */
    function unzip($from, $to)
    {
        $zip = new \ZipArchive();
        if (($error = $zip->open($from)) !== true) {
            return $error;
        }
        $zip->extractTo($to);
        $zip->close();
        return true;
    }
}

if (!function_exists('collectRequest')) {
    /**
     * 将本次请求的所有信息打包成 string
     * @return string
     */
    function collectRequest()
    {
        $getRequest = sprintf("==== GET === \r\n%s\r\n", var_export($_GET, true));
        $postRequest = sprintf("==== POST === \r\n%s\r\n", var_export($_POST, true));
        $request = sprintf("==== Request === \r\n%s\r\n", var_export($_REQUEST, true));
        $phpInput = sprintf("==== file_get_contents(phpinput) === \r\n%s\r\n", var_export(file_get_contents('php://input'), true));
        $serverRequest = sprintf("==== SERVER === \r\n%s\r\n", var_export($_SERVER, true));
        $content = $getRequest . $postRequest . $request . $phpInput . $serverRequest . "\r\n\r\n";
        return $content;
    }
}

if (!function_exists('recordRequest')) {
    /**
     * 记录请求,只在测试环境生效
     */
    function recordRequest()
    {
        if (!config('app.debug') || config('app.env') == 'production') {
            return;
        }

        $content = collectRequest();
        \Log::channel('record-request')->debug($content);
    }
}

if (!function_exists('storageUrl')) {
    /**
     * @param $path string image/material/2021/05/27/26rZIFXN2OYYrXs2tMnHe5NAEheVTKPNGgb4lf3g.png
     * @return string http://api.material.local:81/storage/image/material/2021/05/27/26rZIFXN2OYYrXs2tMnHe5NAEheVTKPNGgb4lf3g.png
     */
    function storageUrl($path)
    {
        $path = ltrim($path, '/');
        $url = config('app.http_api_url') . '/storage/' . $path;
        return $url;
    }
}

if (!function_exists('storageFilePath')) {
    /**
     * @param $path string image/system/flag_return_back.jpg
     * @return string /var/www/storage/app/public/image/system/flag_return_back.jpg
     */
    function storageFilePath($path)
    {
        $path = ltrim($path, '/');
        $path = ltrim($path, '\\');
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $path);
        return $path;
    }
}

if (!function_exists('mpUrl')) {
    /**
     * @param $path string pages/preview/index?id=2
     * @return string https://api.material.liuyublog.com/storage/mp/#/pages/preview/index?id=2
     */
    function mpUrl($path)
    {
        $path = ltrim($path, '/');
        $path = ltrim($path, '\\');
        $url = config('system.mp_base_uri') . '/' . $path;
        return $url;
    }
}

