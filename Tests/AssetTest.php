<?php

namespace Solution\CodeMirrorBundle\Tests;

use Solution\CodeMirrorBundle\Asset\Asset;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AssertTest extends WebTestCase
{
    protected $extension;

    /** @var  ContainerInterface*/
    protected $container;

    protected function setUp()
    {
        $_SERVER['KERNEL_DIR'] = __DIR__.'/../../../../../../app/';

        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->container = static::$kernel->getContainer();

        $this->asset = $this->container->get('code_mirror.asset_manager');
    }

    /**
     * Test instance
     */
    public function testMustBeInstance(){
        $this->assertInstanceOf('Solution\CodeMirrorBundle\Asset\AssetManager', $this->asset);
    }

    /**
     * Test add mode
     */
    public function testAddMode(){
        $mode = array('text/html', '@SolutionCodeMirrorBundle/Resource/public/js/mode/php.js');
        $this->asset->addMode($mode[0], $mode[1]);

        $this->assertEquals($mode[1], $this->asset->getMode($mode[0]));
    }

    /**
     * Test add mode
     */
    public function testTheme(){
        $mode = array('twilight', '@SolutionCodeMirrorBundle/Resource/public/css/theme/twilight.css');
        $this->asset->addTheme($mode[0], $mode[1]);

        $this->assertEquals($mode[1], $this->asset->getTheme($mode[0]));
    }
}