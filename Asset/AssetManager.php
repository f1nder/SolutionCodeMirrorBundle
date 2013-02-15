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

    protected $modes = array();

    protected $themes = array();

    protected $modeDirs = array();

    protected $themesDirs = array();

    protected $cacheDriver;

    protected $env;

    function __construct($fileLocator, $modeDirs, $themesDirs, $cacheDir, $env)
    {
        $this->fileLocator = $fileLocator;
        $this->modeDirs = $modeDirs;
        $this->themesDirs = $themesDirs;
        $this->cacheDriver = new PhpFileCache($cacheDir);
        $this->env = $env;
        #check env and fetch cache
        if ($this->env == 'prod' && $cacheModes = $this->cacheDriver->fetch(static::CACHE_MODES_NAME)) {
            $this->modes = $cacheModes;
        } else {
            $this->parseModes();
        }

        if ($this->env == 'prod' && $cacheThemes = $this->cacheDriver->fetch(static::CACHE_THEMES_NAME)) {
            $this->themes = $cacheThemes;
        } else {
            $this->parseThemes();
        }
    }

    public function addMode($key, $resource)
    {
        $this->modes[$key] = $resource;

        return $this;
    }

    public function getMode($key)
    {
        return isset( $this->modes[$key]) ? $this->modes[$key] : false;
    }

    public function addTheme($key, $resource)
    {
        $this->themes[$key] = $resource;

        return $this;
    }

    public function getTheme($key)
    {
        return isset( $this->themes[$key]) ? $this->themes[$key] : false;
    }

    public function getModes()
    {
        return $this->modes;
    }

    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Parse editor mode from dir
     */
    protected function parseModes()
    {
        foreach ($this->modeDirs as $dir) {
            $absDir = $this->fileLocator->locate($dir);

            $finder = Finder::create()->files()->in($absDir)->name('*.js');

            foreach ($finder as $file) {
                $this->addModesFromFile($file);
            }
        }
        #save to cache if env prod
        if ($this->env == 'prod') {
            $this->cacheDriver->save(static::CACHE_MODES_NAME, $this->getModes());
        }
    }

    /**
     * Parse editor modes from dir
     */
    protected function addModesFromFile($file)
    {
        $jsContent = $file->getContents();
        preg_match_all('#defineMIME\(\s*(\'|")([^\'"]+)(\'|")#', $jsContent, $modes);
        if (count($modes[2])) {
            foreach ($modes[2] as $mode) {
                $this->addMode($mode, $file->getPathname());
            }
        }

                #save to cache if env prod
        if ($this->env == 'prod') {
            $this->cacheDriver->save(static::CACHE_MODES_NAME, $this->getThemes());
        }
    }
    /**
     * Parse editor themes from dir
     */
    protected function parseThemes()
    {
        foreach ($this->themesDirs as $dir) {
            $absDir = $this->fileLocator->locate($dir);
            $finder = Finder::create()->files()->in($absDir)->name('*.css');
            foreach ($finder as $file) {
                $this->addTheme($file->getBasename('.css'), $file->getPathname());
            }
        }
        #save to cache if env prod
        if ($this->env == 'prod') {
            $this->cacheDriver->save(static::CACHE_THEMES_NAME, $this->getThemes());
        }
    }
}

