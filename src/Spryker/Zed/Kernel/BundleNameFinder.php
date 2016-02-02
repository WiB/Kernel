<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel;

use Spryker\Shared\Kernel\AbstractBundle;
use Symfony\Component\Finder\Finder;

class BundleNameFinder extends AbstractBundle
{

    /**
     * @return array
     */
    public function getBundleNames()
    {
        $bundles = [];

        foreach ($this->getFinder() as $bundleDirectory) {
            $bundleName = $bundleDirectory->getRelativePathname();
            $bundles[] = $bundleName;
        }

        $bundles = array_unique($bundles);

        sort($bundles);

        return $bundles;
    }

    /**
     * @return array
     */
    private function getBundleDirectories()
    {
        $vendorBundlePathPattern = rtrim($this->options[self::OPTION_KEY_VENDOR_PATH_PATTERN], DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . $this->options[self::OPTION_KEY_BUNDLE_PATH_PATTERN]
            . $this->options[self::OPTION_KEY_APPLICATION];

        $projectBundlePathPattern = rtrim($this->options[self::OPTION_KEY_PROJECT_PATH_PATTERN])
            . DIRECTORY_SEPARATOR
            . $this->options[self::OPTION_KEY_BUNDLE_PROJECT_PATH_PATTERN]
            . $this->options[self::OPTION_KEY_APPLICATION];

        $dirs = [
            $projectBundlePathPattern,
            $vendorBundlePathPattern,
        ];

        return $dirs;
    }

    /**
     * @return \Symfony\Component\Finder\Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    protected function getFinder()
    {
        $finder = new Finder();
        $dirs = $this->getBundleDirectories();

        return $finder->directories()->in($dirs)->depth(0);
    }

}
