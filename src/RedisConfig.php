<?php

declare(strict_types=1);

namespace PCore\Redis;

use PCore\Utils\Traits\AutoFillProperties;

/**
 * Class RedisConfig
 * @package PCore\Redis
 * @github https://github.com/pcore-framework/redis
 */
class RedisConfig
{

    use AutoFillProperties;

    protected string $name;
    protected string $host = '127.0.0.1';
    protected int $port = 6379;
    protected string $auth = '';
    protected int $database = 0;
    protected int $timeout = 3;
    protected int $readTimeout = 3;
    protected int $retryInterval = 3;
    protected string $reserved = '';
    protected int $poolSize = 64;
    protected bool $autofill = false;

    public function __construct(array $config)
    {
        $this->fillProperties($config);
    }

    public function getAuth(): string
    {
        return $this->auth;
    }

    public function isAutofill(): bool
    {
        return $this->autofill;
    }

    public function getDatabase(): int
    {
        return $this->database;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getReadTimeout(): int
    {
        return $this->readTimeout;
    }

    public function getRetryInterval(): int
    {
        return $this->retryInterval;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReserved(): string
    {
        return $this->reserved;
    }

    public function getPoolSize(): int
    {
        return $this->poolSize;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

}