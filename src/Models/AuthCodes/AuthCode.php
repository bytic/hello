<?php

namespace ByTIC\Hello\Models\AuthCodes;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class Token
 * @package ByTIC\Auth\Models\AuthCodes
 */
class AuthCode extends \Nip\Records\Record implements AuthCodeEntityInterface
{
    use AuthCodeTrait;
    use EntityTrait;
    use TokenEntityTrait;
}
