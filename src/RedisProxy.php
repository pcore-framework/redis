<?php

declare(strict_types=1);

namespace PCore\Redis;

use PCore\Redis\Contracts\ConnectorInterface;
use RedisException;

/**
 * Class RedisProxy
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class RedisProxy
{

    public function __construct(
        protected ConnectorInterface $connector,
        protected $redis
    )
    {
    }

    public function __destruct()
    {
        $this->connector->release($this->redis);
    }

    /**
     * @throws RedisException
     */
    public function __call(string $name, array $arguments)
    {
        try {
            return $this->redis->{$name}(...$arguments);
        } catch (RedisException $redisException) {
            $this->redis = null;
            throw $redisException;
        }
    }

    public function getRedis()
    {
        return $this->redis;
    }

}