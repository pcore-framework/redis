<?php

namespace PCore\Redis\Contracts;

/**
 * Interface ConnectorInterface
 * @package PCore\Redis\Contracts
 * @github https://github.com/pcore-framework/redis
 */
interface ConnectorInterface
{

    public function get();

    public function release($redis);

}