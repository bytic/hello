<?php

namespace ByTIC\Hello\Models\AccessTokens;

use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AccessTokens
 */
class Token extends \Nip\Records\Record
{
    use TokenEntityTrait;
}
