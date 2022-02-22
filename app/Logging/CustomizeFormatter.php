<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\Handler;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        foreach ($logger->getHandlers() as $handler) {
            /** @var Handler $handler */
            $handler->setFormatter(new LineFormatter(
                null,
                'Y-m-d H:i:s',
            ));
        }
    }
}
