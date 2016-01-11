<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\Spryker\Zed\Kernel\ClassResolver\QueryContainer;

use Spryker\Zed\Kernel\ClassResolver\QueryContainer\QueryContainerNotFoundException;
use Spryker\Zed\Kernel\ClassResolver\QueryContainer\QueryContainerResolver;
use Unit\Spryker\Zed\Kernel\ClassResolver\AbstractResolverTest;

/**
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group QueryContainerResolver
 */
class QueryContainerResolverTest extends AbstractResolverTest
{

    protected $coreClass = 'Unit\\Spryker\\Zed\\Kernel\\ClassResolver\\Fixtures\\KernelQueryContainer';
    protected $projectClass = 'Unit\\Pyz\\Zed\\Kernel\\ClassResolver\\Fixtures\\KernelQueryContainer';
    protected $storeClass = 'Unit\\Pyz\\Zed\\KernelDE\\ClassResolver\\Fixtures\\KernelQueryContainer';
    protected $classPattern = 'Unit\\%namespace%\\Zed\\%bundle%%store%\\ClassResolver\\Fixtures\\%bundle%QueryContainer';
    protected $expectedExceptionClass = QueryContainerNotFoundException::class;

    /**
     * @param array $methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|QueryContainerResolver
     */
    protected function getResolverMock(array $methods)
    {
        $resolverMock = $this->getMock(QueryContainerResolver::class, $methods);

        return $resolverMock;
    }

}
