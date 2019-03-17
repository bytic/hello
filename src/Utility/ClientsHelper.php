<?php

namespace ByTIC\Hello\Utility;

/**
 * Class ClientsHelper
 * @package ByTIC\Hello\Utility
 */
class ClientsHelper
{

    const PERSONAL_ACCESS_REDIRECT_URI = 'INTERNAL_API';

    /**
     * The personal access token client ID.
     *
     * @var int
     */
    public static $personalAccessClientId;

    /**
     * Set the client ID that should be used to issue personal access tokens.
     *
     * @param  int $clientId
     * @return static
     */
    public static function personalAccessClientId($clientId)
    {
        static::$personalAccessClientId = $clientId;
        return new static;
    }
}
