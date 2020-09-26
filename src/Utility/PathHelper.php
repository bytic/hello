<?php

namespace ByTIC\Hello\Utility;

use ByTIC\AdminBase\AdminBase;

/**
 * Class PathHelper
 * @package ByTIC\Hello\Utility
 */
class PathHelper
{
    /**
     * @param null $path
     * @return string
     */
    public static function keys($path = null)
    {
        return dirname(dirname(__DIR__))
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'keys'
            . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param $path
     * @param $theme
     * @return string
     */
    public static function views($path, $theme = null)
    {
        return static::viewsTheme($theme) . $path;
    }

    /**
     * @param $theme
     * @return string
     */
    public static function viewsTheme($theme = null)
    {
        $theme = $theme ? $theme : 'bootstrap3';
        return static::viewsBase() . DIRECTORY_SEPARATOR . $theme;
    }

    /**
     * @return string
     */
    public static function viewsBase()
    {
        return dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'themes';
    }
}