<?php

namespace ByTIC\Hello\Utility;

use Nip\Config\Config;

/**
 * Class ConfigHelper
 * @package ByTIC\Hello\Utility
 */
class ConfigHelper
{
    const CONFIG_NAMESPACE = 'hello';

    /**
     * @var null|Config
     */
    protected static $config = null;

    /**
     * @param string $key
     * @param null $default
     * @return mixed|\Nip\Config\Config
     */
    public static function get(string $key, $default = null)
    {
        $key = sprintf('%s.%s', static::CONFIG_NAMESPACE, $key);
        if (static::$config !== null) {
            return static::$config->get($key, $default);
        }
        if (!function_exists('config') || !function_exists('app')) {
            return $default;
        }
        return config($key, $default);
    }

    /**
     * @param Config $object
     */
    public static function setConfig($object)
    {
        static::$config = $object;
    }
}
