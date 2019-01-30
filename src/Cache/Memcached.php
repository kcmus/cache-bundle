<?php

/**
 * @author    Aaron Scherer
 * @date      2014
 * @license   http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 */

namespace KCMUS\Bundle\CacheBundle\Cache;

/**
 * Class Memcached
 *
 *
 */
class Memcached extends \Memcached
{
    /**
     * {@inheritDoc}
     */
    public function addServer($host, $port, $weight = 0)
    {
        $serverList = $this->getServerList();
        foreach ($serverList as $server) {
            if ($server['host'] === $host && $server['port'] === $port) {
                return false;
            }
        }

        return parent::addServer($host, $port, $weight);
    }
}
