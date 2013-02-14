<?php

namespace Solution\CodeMirrorBundle\Tests;

use Solution\CodeMirrorBundle\Twig\CodeMirrorExtension;
use Zend\Json\Json;

class TwigExtensionTestControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;

    protected function setUp()
    {
        $this->extension = new CodeMirrorExtension();
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