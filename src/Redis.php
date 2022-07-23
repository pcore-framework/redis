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

    public function __construct(
        protected ConnectorInterface $connector
    )
    {
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->getHandler()->{$name}(...$arguments);
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->connector->get();
    }

}