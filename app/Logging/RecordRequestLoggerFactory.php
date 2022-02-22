<?php

namespace App\Logging;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class RecordRequestLoggerFactory
{
    /**
     * 创建一个 Monolog 实例
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        // create a log channel
        $filePath = storage_path('logs/' . where() . '-record-request.log');
        $maxFiles = $config['maxFiles'] ?? 1;
        $log = new Logger('name');
        $log->pushHandler(new RotatingFileHandler($filePath, $maxFiles, Logger::DEBUG));

        return $log;
    }
}
