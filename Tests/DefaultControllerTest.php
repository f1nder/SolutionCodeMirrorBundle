<?php

namespace Solution\CodeMirrorBundle\Tests;

use Solution\CodeMirrorBundle\Twig\CodeMirrorExtension;
use Zend\Json\Json;

class TwigExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;

    protected function setUp()
    {
        $this->extension = new CodeMirrorExtension();
    }

    /**
     * Must be first call by default
     */
    public function testIsFirstCallByDefault()
    {
        $this->assertEquals(true, $this->extension->isFirstCall());

        $this->extension->parametersRender(array());

        $this->assertEquals(false, $this->extension->isFirstCall());
    }

    /**
     * Test render js parameters
     *
     * @dataProvider dataForRenderParameters
     *
     * @param $parameters
     * @param $return
     */
    public function testRenderParameters($parameters, $return)
    {
        $this->assertEquals($return, $this->extension->parametersRender($parameters));
    }

    /**
     * @return array
     */
    static public function  dataForRenderParameters()
    {
        return array(
            array(
                array(
                    'linenumbers' => true
                ),
                '{"linenumbers":true}'
            ),
            array(
                array(
                    'linenumbers' => true,
                    'mode' => 'text/html'
                ),
                '{"linenumbers":true,"mode":"text/html"}'
            ),
            array(
                array(
                    'linenumbers' => true,
                    'mode' => 'text/html',
                    'theme' => 'eclipse'
                ),
                '{"linenumbers":true,"mode":"text/html","theme":"eclipse"}'
            ),
        );
    }
}