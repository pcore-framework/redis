<?php

declare(strict_types=1);

use PCore\Redis\Connectors\AutoConnector;
use PCore\Redis\RedisConfig;

return [
    'default' => 'redis',
    'connections' => [
        'redis' => [
            'connector' => AutoConnector::class,
            'options' => [
                RedisConfig::OPTION_HOST => '127.0.0.1',
                RedisConfig::OPTION_PORT => 6379,
                RedisConfig::OPTION_AUTH => '',
                RedisConfig::OPTION_DATABASE => 0,
                RedisConfig::OPTION_TIMEOUT => 3,
                RedisConfig::OPTION_READ_TIMEOUT => 3,
                RedisConfig::OPTION_RETRY_INTERVAL => 3,
                RedisConfig::OPTION_RESERVED => '',
                RedisConfig::OPTION_POOL_SIZE => 64
            ]
        ]
    ]
];