<?php

declare(strict_types=1);

namespace PCore\Redis\Connectors;

use PCore\Redis\Contracts\ConnectorInterface;
use PCore\Redis\RedisProxy;

/**
 * Class BaseConnector
 * @package PCore\Redis\Connectors
 * @github https://github.com/pcore-framework/redis
 */
class BaseConnector implements ConnectorInterface
{

    protected \SplPriorityQueue $queue;

    public function __construct(
        protected string $host = '127.0.0.1',
        protected int $port = 6379,
        protected float $timeout = 0.0,
        protected $reserved = null,
        protected int $retryInterval = 0,
        protected float $readTimeout = 0.0,
        protected string $auth = '',
        protected int $database = 0
    )
    {
        $this->queue = new \SplPriorityQueue();
    }

    public function get()
    {
        $redis = new \Redis();
        $redis->connect(
            $this->host,
            $this->port,
            $this->timeout,
            $this->reserved,
            $this->retryInterval,
            $this->readTimeout
        );
        $redis->select($this->database);
        $this->auth && $redis->auth($this->auth);
        return new RedisProxy($this, $redis);
    }

    public function release($redis)
    {
    }

}