<?php

namespace ByTIC\Hello\Models\RefreshTokens;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

/**
 * Class Token
 * @package ByTIC\Auth\Models\RefreshTokens
 */
class RefreshToken extends \Nip\Records\Record implements RefreshTokenEntityInterface
{
    use EntityTrait;
    use RefreshTokenTrait;
}
