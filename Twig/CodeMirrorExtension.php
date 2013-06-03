<?php
namespace Solution\CodeMirrorBundle\Twig;

use Zend\Json\Json;
use Zend\Json\Expr;

use Assetic\AssetManager;
use Assetic\Asset\FileAsset;

class CodeMirrorExtension extends \Twig_Extension
{
    /**
     * @var AssetManager
     */
    protected $assetManager;

    function __construct($assetManager)
    {
        $this->assetManager = $assetManager;
    }

    protected $isFirstCall = true;

    public function getFunctions()
    {
        return array(
            'code_mirror_parameters_render' => new \Twig_Function_Method($this, 'parametersRender', array('is_safe' => array('html'))),
            'code_mirror_is_first_call' => new \Twig_Function_Method($this, 'isFirstCall'),
            'code_mirror_get_js_mode' => new \Twig_Function_Method($this, 'code_mirror_get_js_mode'),
            'code_mirror_get_css_theme' => new \Twig_Function_Method($this, 'code_mirror_get_css_theme'),
        );
    }

    public function parametersRender($paramters)
    {
        if (isset($paramters['mode'])) {
            $paramters['mode'] = new Expr('"' . $paramters['mode'] . '"');
        }
        $params = Json::encode($paramters, false, array('enableJsonExprFinder' => true));

        $this->isFirstCall = false;

        return $params;
    }

    public function code_mirror_get_js_mode($parameters)
    {
        return $this->assetManager->getMode($parameters['mode']);
    }

    public function code_mirror_get_css_theme($parameters)
    {
        $am = new AssetManager();
        $am->set('theme', new FileAsset($parameters['theme']));
        $am->get('theme');

        #var_dump($am, $am->get('theme'), $am->getNames()); die;

        if(isset($parameters['theme']) AND $theme = $this->assetManager->getTheme($parameters['theme'])) {
            return $theme;
        }
        return false;
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
