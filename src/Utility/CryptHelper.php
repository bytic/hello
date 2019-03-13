<?php

namespace ByTIC\Hello\Utility;

/**
 * Class Helper
 * @package ByTIC\Hello\Utility
 */
class CryptHelper
{
    /**
     * The storage location of the encryption keys.
     *
     * @var string
     */
    public static $keyPath;

    /**
     * Set the storage location of the encryption keys.
     *
     * @param  string  $path
     * @return void
     */
    public static function loadKeysFrom($path)
    {
        static::$keyPath = $path;
    }

    /**
     * The location of the encryption keys.
     *
     * @param string $file
     * @return string
     */
    public static function keyPath($file)
    {
        $file = ltrim($file, '/\\');
        return static::$keyPath
            ? rtrim(static::$keyPath, '/\\') . DIRECTORY_SEPARATOR . $file
            : storage_path($file);
    }
}
