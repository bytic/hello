<?php

namespace ByTIC\Hello\Utility;

/**
 * Class ConfigHelper
 * @package ByTIC\Hello\Utility
 */
class ConfigHelper
{
    const CONFIG_NAMESPACE = 'hello';

    /**
     * @param string $key
     * @param null $default
     * @return mixed|\Nip\Config\Config
     */
    public static function get(string $key, $default = null)
    {
        return config(sprintf('%s.%s', static::CONFIG_NAMESPACE, $key), $default);
    }
}
