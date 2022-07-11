<?php

namespace PCore\Redis;

use PCore\Redis\Contracts\ConnectorInterface;

/**
 * Class Redis
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class Redis
{

    protected \Redis $redis;

    public function __construct(protected ConnectorInterface $connector)
    {
        $this->redis = $this->connector->get();
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->redis->{$name}(...$arguments);
    }

    public function __destruct()
    {
        $this->connector->release($this->redis);
    }

}