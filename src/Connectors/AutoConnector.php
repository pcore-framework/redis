<?php

declare(strict_types=1);

namespace PCore\Redis\Connectors;

use ArrayObject;
use PCore\Redis\Contracts\ConnectorInterface;
use PCore\Redis\RedisConfig;
use Swoole\Coroutine;

/**
 * Class AutoConnector
 * @package PCore\Redis\Connectors
 * @github https://github.com/pcore-framework/redis
 */
class AutoConnector implements ConnectorInterface
{

    protected array $connectors = [
        'pool' => PoolConnector::class,
        'base' => BaseConnector::class
    ];

    protected ?ArrayObject $pool = null;

    public function __construct(protected RedisConfig $config)
    {
        $this->pool = new ArrayObject();
    }

    public function get(): \Redis
    {
        $type = $this->getConnectorType();
        if (!$this->pool->offsetExists($type)) {
            $connector = $this->connectors[$type];
            $this->pool->offsetSet($type, new $connector($this->config));
        }

        return $this->pool->offsetGet($type)->get();
    }

    public function release($redis)
    {
        $this->pool->offsetGet($this->getConnectorType())->release($redis);
    }

    protected function getConnectorType(): string
    {
        return class_exists(Coroutine::class) && Coroutine::getCid() > 0 ? 'pool' : 'base';
    }

}