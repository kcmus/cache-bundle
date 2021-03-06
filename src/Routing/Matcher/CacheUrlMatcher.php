<?php

/**
 * @author    Aaron Scherer
 * @date      12/11/13
 * @license   http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 */

namespace KCMUS\Bundle\CacheBundle\Routing\Matcher;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use KCMUS\Bundle\CacheBundle\Service\CacheService;

/**
 * Class CacheUrlMatcher
 *
 *
 */
class CacheUrlMatcher extends UrlMatcher
{
    /**
     * @var CacheService
     */
    protected $cache;

    /**
     * @param string $pathInfo
     *
     * @return array
     */
    public function match($pathInfo)
    {
        $key = 'route_' . $pathInfo;
        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $match = parent::match($pathInfo);
        $this->cache->save($key, $match, 60 * 60 * 24 * 7);

        return $match;
    }

    /**
     * @param CacheService $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return CacheService
     */
    public function getCache()
    {
        return $this->cache;
    }
}
