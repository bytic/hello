<?php

namespace ByTIC\Hello\Utility;

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
}