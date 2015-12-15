<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\Persistence;

use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\Kernel\ClassResolver\DependencyContainer\DependencyContainerResolver;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Persistence\DependencyContainer\DependencyContainerInterface;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

abstract class AbstractQueryContainer implements QueryContainerInterface
{

    const DEPENDENCY_CONTAINER = 'DependencyContainer';
    const PROPEL_CONNECTION = 'propel connection';

    /**
     * @var DependencyContainerInterface
     */
    private $dependencyContainer;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     *
     * @return self
     */
    public function setExternalDependencies(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function getProvidedDependency($key)
    {
        if ($this->container->offsetExists($key) === false) {
            throw new \ErrorException('Key ' . $key . ' does not exist in container.');
        }

        return $this->container[$key];
    }

    /**
     * @return AbstractPersistenceDependencyContainer
     */
    protected function getDependencyContainer()
    {
        if ($this->dependencyContainer === null) {
            $this->dependencyContainer = $this->resolveDependencyContainer();
        }

        if ($this->container !== null) {
            $this->dependencyContainer->setContainer($this->container);
        }

        return $this->dependencyContainer;
    }

    /**
     * @throws \Exception
     *
     * @return AbstractPersistenceDependencyContainer
     */
    private function resolveDependencyContainer()
    {
        return $this->getQueryContainerResolver()->resolve($this);
    }

    /**
     * @return DependencyContainerResolver
     */
    protected function getQueryContainerResolver()
    {
        return new DependencyContainerResolver();
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->getProvidedDependency(self::PROPEL_CONNECTION);
    }

}