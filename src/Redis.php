<?php

namespace PCore\Redis;

use Closure;
use PCore\Redis\Contracts\ConnectorInterface;
use Throwable;

/**
 * Class Redis
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class Redis
{

    public function __construct(
        protected ConnectorInterface $connector
    )
    {
    }

    public function __call(string $name, array $arguments)
    {
        return $this->connector->get()->{$name}(...$arguments);
    }

    /**
     * @param null|mixed $redis
     * @throws Throwable
     */
    public function wrap(Closure $wrapper, $redis = null)
    {
        return $wrapper($redis ?? $this->connector->get());
    }

    /**
     * @throws Throwable
     */
    public function multi(Closure $wrapper, int $mode = \Redis::MULTI)
    {
        return $this->wrap(function ($redis) use ($wrapper, $mode) {
            try {
                /* @var \Redis $redis */
                $redis->multi($mode);
                $result = $wrapper($redis);
                $redis->exec();
                return $result;
            } catch (Throwable $throwable) {
                $redis->discard();
                throw $throwable;
            }
        });
    }

}