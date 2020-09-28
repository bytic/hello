<?php

namespace ByTIC\Hello\Utility;

/**
 * Class ThemeHelper
 * @package ByTIC\Hello\Utility
 */
class ThemeHelper
{
    protected static $theme = 'bootstrap3';

    /**
     * @param null $new
     * @return string|void
     */
    public static function theme($new = null)
    {
        if ($new !== null) {
            return static::setTheme($new);
        }
        return static::$theme;
    }

    /**
     * @param string $new
     */
    protected static function setTheme($new)
    {
        static::$theme = $new;
    }
}