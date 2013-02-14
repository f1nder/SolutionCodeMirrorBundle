<?php

namespace Solution\CodeMirrorBundle\Asset;

use Symfony\Component\HttpKernel\Config\FileLocator;

class AssetManager
{
    /** @var  FileLocator */

    protected $fileLocator;

    protected $modes = array();

    protected $themes = array();

    function __construct($fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    public function addMode($key, $resource)
    {
        $this->modes[$key] = $resource;

        return $this;
    }

    public function getMode($key)
    {
        return $this->modes[$key];
    }

    public function addTheme($key, $resource)
    {
        $this->themes[$key] = $resource;

        return $this;
    }

    public function getTheme($key)
    {
        return $this->themes[$key];
    }
}

