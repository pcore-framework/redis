<?php

declare(strict_types=1);

namespace PCore\Redis;

use ArrayObject;
use InvalidArgumentException;
use PCore\Config\Contracts\ConfigInterface;

/**
 * Class RedisManager
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class RedisManager
{

    protected string $defaultConnection;
    protected array $config = [];
    protected ?ArrayObject $connections = null;

    public function __construct(ConfigInterface $config)
    {
        $config = $config->get('redis');
        $this->defaultConnection = $config['default'];
        $this->config = $config['connections'] ?? [];
        $this->connections = new ArrayObject();
    }

    public function connection(?string $name = null): Redis
    {
        $name ??= $this->defaultConnection;
        if (!$this->connections->offsetExists($name)) {
            if (!isset($this->config[$name])) {
                throw new InvalidArgumentException('Нет соответствующего подключения к Redis');
            }
            $config = $this->config[$name];
            $connector = $config['connector'];
            $options = $config['options'];
            $options['name'] = $name;
            $this->connections->offsetSet($name, new $connector(new RedisConfig($options)));
        }
        return new Redis($this->connections->offsetGet($name));
    }

}