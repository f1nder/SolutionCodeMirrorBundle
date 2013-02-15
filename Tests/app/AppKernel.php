<?php

namespace Solution\CodeMirrorBundle\Tests\App;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Solution\CodeMirrorBundle\SolutionCodeMirrorBundle(),
    )
    ;

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config_test.yml');
    }
}