<?php

/**
 * @author    Aaron Scherer
 * @date      12/6/13
 * @license   http://www.apache.org/licenses/LICENSE-2.0.html Apache License, Version 2.0
 */

namespace KCMUS\Bundle\CacheBundle\DependencyInjection\Builder;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class BaseBuilder
 *
 *
 */
abstract class BaseBuilder
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;

        $this->prepare();
    }

    /**
     * @return string
     */
    protected function getAlias()
    {
        return 'kcmus_cache';
    }

    /**
     * @return mixed
     */
    abstract protected function prepare();
}
