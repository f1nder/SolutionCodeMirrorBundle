<?php
namespace Solution\CodeMirrorBundle\Twig;

use Zend\Json\Json;
use Zend\Json\Expr;

class CodeMirrorExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'code_mirror_parameters_render' => new \Twig_Function_Method($this, 'parametersRender', array('is_safe' => array('html'))),
        );
    }

    public function parametersRender($paramters)
    {
        #convert mode to more friendly format
        if (isset($paramters['mode'])) {
            $paramters['mode'] = new Expr('"' . $paramters['mode'] . '"');
        }

        $params = Json::encode($paramters, false, array('enableJsonExprFinder' => true));

        return $params;
    }

    public function getName()
    {
        return 'code_mirror_extension';
    }
}
