<?php
namespace Solution\CodeMirrorBundle\Twig;

use Zend\Json\Json;
use Zend\Json\Expr;

class CodeMirrorExtension extends \Twig_Extension
{
    protected $isFirstCall = true;

    public function getFunctions()
    {
        return array(
            'code_mirror_parameters_render' => new \Twig_Function_Method($this, 'parametersRender', array('is_safe' => array('html'))),
            'code_mirror_is_first_call' => new \Twig_Function_Method($this, 'isFirstCall'),
        );
    }

    public function parametersRender($paramters)
    {
        #convert mode to more friendly format
        if (isset($paramters['mode'])) {
            $paramters['mode'] = new Expr('"' . $paramters['mode'] . '"');
        }
        $params = Json::encode($paramters, false, array('enableJsonExprFinder' => true));

        $this->isFirstCall = false;

        return $params;
    }

    public function isFirstCall()
    {
        return $this->isFirstCall;
    }

    public function getName()
    {
        return 'code_mirror_extension';
    }
}
