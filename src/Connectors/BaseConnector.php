<?php

declare(strict_types=1);

namespace PCore\Redis\Connectors;

use PCore\Redis\Contracts\ConnectorInterface;
use PCore\Redis\RedisConfig;

/**
 * Class BaseConnector
 * @package PCore\Redis\Connectors
 * @github https://github.com/pcore-framework/redis
 */
class BaseConnector implements ConnectorInterface
{

    protected \ArrayObject $pool;

    public function __construct(protected RedisConfig $config)
    {
        $this->pool = new \ArrayObject();
    }

    public function get(): \Redis
    {
        $name = $this->config->getName();
        if (!$this->pool->offsetExists($name)) {
            $redis = new \Redis();
            $redis->connect(
                $this->config->getHost(),
                $this->config->getPort(),
                $this->config->getTimeout(),
                $this->config->getReserved(),
                $this->config->getRetryInterval(),
                $this->config->getReadTimeout()
            );
            $redis->select($this->config->getDatabase());
            if ($auth = $this->config->getAuth()) {
                $redis->auth($auth);
            }
            $this->pool->offsetSet($name, $redis);
        }

        $redis = $this->pool->offsetGet($name);
        $this->pool->offsetUnset($name);
        return $redis;
    }

    public function release($redis)
    {
        $this->pool->offsetSet($this->config->getName(), $redis);
    }

}