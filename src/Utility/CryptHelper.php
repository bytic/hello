<?php

namespace ByTIC\Hello\Utility;

use League\OAuth2\Server\CryptKey;
use phpseclib\Crypt\RSA;

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
     * @param string $path
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
        if (static::$keyPath) {
            return rtrim(static::$keyPath, '/\\') . DIRECTORY_SEPARATOR . $file;
        }
        if (function_exists('Nip\storage_path')) {
            return \Nip\storage_path('hello\keys\\' . $file);
        }
        return PathHelper::keys($file);
    }

    /**
     * @param null $basePath
     * @return bool
     */
    public static function generateKeys($basePath = null)
    {
        $privateKeyName = 'oauth-private.key';
        $publicKeyName = 'oauth-public.key';
        $privateKeyPath = $basePath ? $basePath . DIRECTORY_SEPARATOR . $privateKeyName : static::keyPath($privateKeyName);
        $publicKeyPath = $basePath ? $basePath . DIRECTORY_SEPARATOR . $publicKeyName : static::keyPath($publicKeyName);

        $rsa = new RSA();
        $keys = $rsa->createKey(2048, false);

        file_put_contents($privateKeyPath, $keys['privatekey']);
        file_put_contents($publicKeyPath, $keys['publickey']);

        $result = chmod($privateKeyPath, 0600);
        $result = $result && chmod($publicKeyPath, 0600);

        return $result;
    }

    /**
     * @param $type
     * @return CryptKey
     */
    public static function makeCryptKey($type)
    {
        $configKey = null;
        $configKey = ConfigHelper::get($type . '_key');

        $key = str_replace('\\n', "\n", $configKey);
        if (!$key) {
            $path = CryptHelper::keyPath('oauth-' . $type . '.key');
            if (!file_exists($path)) {
                CryptHelper::generateKeys(dirname($path));
            }
            $key = 'file://' . $path;
        }

        return new CryptKey($key, null, false);
    }
}
