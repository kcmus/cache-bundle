<?php

/**
 * This file is part of cache-bundle
 *
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE
 */

namespace KCMUS\Bundle\CacheBundle\Cache;

use KCMUS\Cache\CacheItem;
use KCMUS\Cache\CachePool;
use Psr\Cache\CacheItemInterface;

/**
 *
 */
class LoggingCachePool extends CachePool
{
    /**
     * @var array $calls
     */
    private $calls = [];

    public function getItem($key)
    {
        $call         = $this->timeCall(__FUNCTION__, [$key]);
        $result       = $call->result;
        $call->result = sprintf('<DATA:%s>', gettype($result));

        $this->calls[] = $call;

        return $result;
    }

    public function hasItem($key)
    {
        $call          = $this->timeCall(__FUNCTION__, [$key]);
        $this->calls[] = $call;

        return $call->result;
    }

    public function deleteItem($key)
    {
        $call          = $this->timeCall(__FUNCTION__, [$key]);
        $this->calls[] = $call;

        return $call->result;
    }

    public function save(CacheItemInterface $item)
    {
        $itemClone       = clone $item;
        $itemClone->set(sprintf('<DATA:%s', gettype($item->get())));

        $call            = $this->timeCall(__FUNCTION__, [$item]);
        $call->arguments = ['<CacheItem>', $itemClone];
        $this->calls[]   = $call;

        return $call->result;
    }

    /**
     * @param string $name
     * @param        $arguments
     *
     * @return object
     */
    private function timeCall($name, $arguments)
    {
        $start  = microtime(true);
        $result = call_user_func_array(['parent', $name], $arguments);
        $time   = microtime(true) - $start;

        $object = (object) compact('name', 'arguments', 'start', 'time', 'result');

        return $object;
    }

    /**
     * @return array
     */
    public function getCalls()
    {
        return $this->calls;
    }
}
