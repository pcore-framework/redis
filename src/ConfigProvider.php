<?php

declare(strict_types=1);

namespace PCore\Redis;

/**
 * Class ConfigProvider
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class ConfigProvider
{

    public function __invoke()
    {
        return [
            'publish' => [
                [
                    'name' => 'redis',
                    'source' => __DIR__ . '/../publish/redis.php',
                    'destination' => dirname(__DIR__, 4) . '/config/redis.php'
                ]
            ]
        ];
    }

}