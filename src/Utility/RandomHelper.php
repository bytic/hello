<?php

namespace ByTIC\Hello\Utility;

/**
 * Class RandomHelper
 * @package ByTIC\Hello\Utility
 */
final class RandomHelper
{
    /**
     * @return mixed
     */
    public static function generateToken()
    {
        $bytes = random_bytes(32);
        return base_convert(bin2hex($bytes), 16, 36);
    }
}
