<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Service\Kernel\ClassResolver\DependencyProvider;

use Spryker\Service\Kernel\ClassResolver\DependencyProvider\DependencyProviderNotFoundException;
use Spryker\Service\Kernel\ClassResolver\DependencyProvider\DependencyProviderResolver;
use Unit\Spryker\Service\Kernel\ClassResolver\AbstractResolverTest;

/**
 * @group Unit
 * @group Spryker
 * @group Service
 * @group Kernel
 * @group ClassResolver
 * @group DependencyProvider
 * @group DependencyProviderResolverTest
 */
class DependencyProviderResolverTest extends AbstractResolverTest
{

    /**
     * @var string
     */
    protected $projectClass = 'Unit\\ProjectNamespace\\Service\\Kernel\\ClassResolver\\Fixtures\\KernelDependencyProvider';

    /**
     * @var string
     */
    protected $storeClass = 'Unit\\ProjectNamespace\\Service\\KernelDE\\ClassResolver\\Fixtures\\KernelDependencyProvider';

    /**
     * @var string
     */
    protected $classPattern = 'Unit\\%namespace%\\Service\\%bundle%%store%\\ClassResolver\\Fixtures\\%bundle%DependencyProvider';

    /**
     * @var string
     */
    protected $expectedExceptionClass = DependencyProviderNotFoundException::class;

    /**
     * @param array $methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Service\Kernel\ClassResolver\DependencyProvider\DependencyProviderResolver
     */
    protected function getResolverMock(array $methods)
    {
        $resolverMock = $this->getMockBuilder(DependencyProviderResolver::class)->setMethods($methods)->getMock();

        return $resolverMock;
    }

}
