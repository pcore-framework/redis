<?php

declare(strict_types=1);

namespace PCore\Redis\Connectors;

use PCore\Redis\Contracts\ConnectorInterface;
use PCore\Redis\RedisConfig;
use Swoole\Database\RedisPool;

/**
 * Class PoolConnector
 * @package PCore\Redis\Connectors
 * @github https://github.com/pcore-framework/redis
 */
class PoolConnector implements ConnectorInterface
{

    protected RedisPool $pool;

    /**
     * @param RedisConfig $config
     */
    public function __construct(protected RedisConfig $config)
    {
        $this->pool = new RedisPool((new \Swoole\Database\RedisConfig())
            ->withHost($this->config->getHost())
            ->withPort($this->config->getPort())
            ->withTimeout($this->config->getTimeout())
            ->withReadTimeout($this->config->getReadTimeout())
            ->withRetryInterval($this->config->getRetryInterval())
            ->withReserved($this->config->getReserved())
            ->withDbIndex($this->config->getDatabase())
            ->withAuth($this->config->getAuth()),
            $this->config->getPoolSize()
        );
    }

    /**
     * @throws \RedisException
     */
    public function get(): \Redis
    {
        try {
            $redis = $this->pool->get();
            $redis->ping();
            return $redis;
        } catch (\RedisException $redisException) {
            $this->pool->put(null);
            throw $redisException;
        }
    }

    public function release(\Redis $redis)
    {
        $this->pool->put($redis);
    }

}