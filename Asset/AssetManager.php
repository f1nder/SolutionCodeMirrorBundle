<?php

namespace Solution\CodeMirrorBundle\Asset;

use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Cache\PhpFileCache;

class AssetManager
{
    const CACHE_MODES_NAME = 'solution.code.mirror.modes';
    const CACHE_THEMES_NAME = 'solution.code.mirror.themes';

    /** @var  FileLocator */
    protected $fileLocator;

    /** @var  Finder */
    protected $finder;

    protected $modes = array();

    protected $themes = array();

    protected $modeDirs = array();

    protected $cacheDriver;

    function __construct($fileLocator, $modeDirs)
    {
        $this->fileLocator = $fileLocator;
        $this->modeDirs = $modeDirs;
        $this->finder = new Finder();
        $this->cacheDriver = new PhpFileCache(__DIR__);

        if ($cacheModes = $this->cacheDriver->fetch(static::CACHE_MODES_NAME)) {
            $this->modes = $cacheModes;
        } else {
            $this->parseModes();
        }
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

    public function getModes()
    {
        return $this->modes;
    }

    protected function parseModes()
    {
        foreach ($this->modeDirs as $dir) {
            $absDir = $this->fileLocator->locate($dir);
            $this->finder->files()->in($absDir)->name('*.js');
            foreach ($this->finder as $file) {
                $this->addModesFromFile($file);
            }
        }
        #save to cache
       $this->cacheDriver->save(static::CACHE_MODES_NAME, $this->getModes());
    }

    protected function addModesFromFile($file)
    {
        $jsContent = $file->getContents();
        preg_match_all('#defineMIME\(\s*(\'|")([^\'"]+)(\'|")#', $jsContent, $modes);
        if (count($modes[2])) {
            foreach ($modes[2] as $mode) {
                $this->addMode($mode, $file->getPathname());
            }
        }
    }
}

