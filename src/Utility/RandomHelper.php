<?php

namespace ByTIC\Hello\Utility;

/**
 * Class RandomHelper
 * @package ByTIC\Hello\Utility
 */
final class RandomHelper
{
    /** @noinspection PhpDocMissingThrowsInspection
     * @return mixed
     */
    public static function generateToken()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $bytes = random_bytes(32);
        return base_convert(bin2hex($bytes), 16, 36);
    }

    /** @noinspection PhpDocMissingThrowsInspection
     * @return string
     */
    public static function generateIdentifier()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return hash('md5', random_bytes(16));
    }
}
