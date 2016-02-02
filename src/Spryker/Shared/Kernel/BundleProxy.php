<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Shared\Kernel;

use Spryker\Shared\Kernel\Locator\LocatorInterface;

class BundleProxy
{

    const LOCATOR_MATCHER_SUFFIX = 'Matcher';

    /**
     * @var string
     */
    private $bundle;

    /**
     * @var \Spryker\Shared\Kernel\Locator\LocatorInterface[]
     */
    private $locator;

    /**
     * @var \Spryker\Shared\Kernel\Locator\LocatorMatcherInterface[]
     */
    private $locatorMatcher;

    /**
     * @param string $bundle
     *
     * @return self
     */
    public function setBundle($bundle)
    {
        $this->bundle = ucfirst($bundle);

        return $this;
    }

    /**
     * @param array $locator
     *
     * @return self
     */
    public function setLocator(array $locator = [])
    {
        foreach ($locator as $aLocator) {
            $this->addLocator($aLocator);
        }

        return $this;
    }

    /**
     * @param \Spryker\Shared\Kernel\Locator\LocatorInterface $locator
     *
     * @return self
     */
    public function addLocator(LocatorInterface $locator)
    {
        $locatorClass = get_class($locator);
        $matcherClass = $locatorClass . self::LOCATOR_MATCHER_SUFFIX;
        if (!class_exists($matcherClass)) {
            throw new \LogicException(sprintf('Could not find a "%s"!', $matcherClass));
        }
        $matcher = new $matcherClass();

        $this->locator[] = $locator;
        $this->locatorMatcher[$locatorClass] = $matcher;

        return $this;
    }

    /**
     * TODO Check if performance is good enough here!?
     *
     * @param string $method
     * @param string $arguments
     *
     * @return object
     */
    public function __call($method, $arguments)
    {
        foreach ($this->locator as $locator) {
            $matcher = $this->locatorMatcher[get_class($locator)];
            if ($matcher->match($method)) {
                return $locator->locate($this->bundle, $matcher->filter($method));
            }
        }

        throw new \LogicException(sprintf('Could not map method "%s" to a locator!', $method));
    }

}
