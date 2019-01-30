<?php

/**
 * @author    Aaron Scherer
 * @date      12/6/13
 * @license   http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 */

namespace KCMUS\Bundle\CacheBundle\DependencyInjection\Builder;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Class RouterBuilder
 *
 *
 */
class RouterBuilder extends BaseBuilder
{
    /**
     * {@inheritDoc}
     */
    protected function prepare()
    {
        $router = $this->container->getParameter($this->getAlias() . '.router');

        if ($router['enabled']) {
            $this->buildRouter($router);
        }
    }

    /**
     * @param array $config
     *
     * @throws InvalidConfigurationException
     */
    private function buildRouter(array $config)
    {
        $instance = $config['instance'];
        $instances = $this->container->getParameter($this->getAlias() . '.instance');

        if (null === $instance) {
            throw new InvalidConfigurationException('Failed to hook into the router. No instance was passed.');
        }
        if (!isset($instances[$instance])) {
            throw new InvalidConfigurationException(sprintf(
                "Failed to hook into the router. The instance \"%s\" doesn't exist!",
                $instance
            ));
        }

        if (!in_array(strtolower($instances[$instance]['type']), array('memcache', 'redis', 'memcached'))) {
            throw new InvalidConfigurationException(sprintf(
                "%s is not a valid cache type for router support. Please use Memcache, Memcached, or Redis. ",
                $instances[$instance]['type']
            ));
        }

        $this->container->setParameter('router.class', 'KCMUS\Bundle\CacheBundle\Routing\Router');
    }
}
